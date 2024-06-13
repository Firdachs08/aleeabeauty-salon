<?php

namespace App\Http\Controllers;

use Exception;
use Midtrans\Snap;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Shipment;
use App\Models\OrderItem;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function process()
    {
        if (\Cart::isEmpty()) {
            return redirect()->route('cart.index');
        }

        $items = \Cart::getContent();

        return view('frontend.orders.checkout', compact('items'));
    }

    public function cities(Request $request)
    {
        $cities = $this->getCities($request->query('province_id'));
        return response()->json(['cities' => $cities]);
    }

    public function shippingCost(Request $request)
    {
        $items = \Cart::getContent();

        $totalWeight = 0;
        foreach ($items as $item) {
            $totalWeight += ($item->quantity * $item->associatedModel->weight);
        }

        $destination = $request->input('city_id');
        return $this->getShippingCost($destination, $totalWeight);
    }

    private function getShippingCost($destination, $weight)
    {
        $params = [
            'origin' => env('RAJAONGKIR_ORIGIN'),
            'destination' => $destination,
            'weight' => $weight,
        ];

        $results = [];
        foreach ($this->couriers as $code => $courier) {
            $params['courier'] = $code;

            $response = $this->rajaOngkirRequest('cost', $params, 'POST');

            if (!empty($response['rajaongkir']['results'])) {
                foreach ($response['rajaongkir']['results'] as $cost) {
                    if (!empty($cost['costs'])) {
                        foreach ($cost['costs'] as $costDetail) {
                            $serviceName = strtoupper($cost['code']) . ' - ' . $costDetail['service'];
                            $costAmount = $costDetail['cost'][0]['value'];
                            $etd = $costDetail['cost'][0]['etd'];

                            $result = [
                                'service' => $serviceName,
                                'cost' => $costAmount,
                                'etd' => $etd,
                                'courier' => $code,
                            ];

                            $results[] = $result;
                        }
                    }
                }
            }
        }

        $response = [
            'origin' => $params['origin'],
            'destination' => $destination,
            'weight' => $weight,
            'results' => $results,
        ];

        return $response;
    }

    public function setShipping(Request $request)
    {
        \Cart::removeConditionsByType('shipping');

        $items = \Cart::getContent();

        $totalWeight = 0;
        foreach ($items as $item) {
            $totalWeight += ($item->quantity * $item->associatedModel->weight);
        }

        $shippingService = $request->get('shipping_service');
        $destination = $request->get('city_id');

        $shippingOptions = $this->getShippingCost($destination, $totalWeight);

        $selectedShipping = null;
        if ($shippingOptions['results']) {
            foreach ($shippingOptions['results'] as $shippingOption) {
                if (str_replace(' ', '', $shippingOption['service']) == $shippingService) {
                    $selectedShipping = $shippingOption;
                    break;
                }
            }
        }

        $status = null;
        $message = null;
        $data = [];
        if ($selectedShipping) {
            $status = 200;
            $message = 'Success set shipping cost';

            $this->addShippingCostToCart($selectedShipping['service'], $selectedShipping['cost']);

            $data['total'] = number_format(\Cart::getTotal());
        } else {
            $status = 400;
            $message = 'Failed to set shipping cost';
        }

        $response = [
            'status' => $status,
            'message' => $message
        ];

        if ($data) {
            $response['data'] = $data;
        }

        return $response;
    }

    private function addShippingCostToCart($serviceName, $cost)
    {
        $condition = new \Darryldecode\Cart\CartCondition(
            [
                'name' => $serviceName,
                'type' => 'shipping',
                'target' => 'total',
                'value' => '+' . $cost,
            ]
        );

        \Cart::condition($condition);
    }

    private function getSelectedShipping($destination, $totalWeight, $shippingService)
    {
        $shippingOptions = $this->getShippingCost($destination, $totalWeight);

        $selectedShipping = null;
        if ($shippingOptions['results']) {
            foreach ($shippingOptions['results'] as $shippingOption) {
                if (str_replace(' ', '', $shippingOption['service']) == $shippingService) {
                    $selectedShipping = $shippingOption;
                    break;
                }
            }
        }

        return $selectedShipping;
    }

    public function checkout(Request $request)
    {
        $token = $request->except('_token');
    
        $order = \DB::transaction(function () use ($token) {
    
            $baseTotalPrice = \Cart::getSubTotal();
    
            $orderDate = date('Y-m-d H:i:s');
            $paymentDue = (new \DateTime($orderDate))->modify('+3 day')->format('Y-m-d H:i:s');
    
            $orderParams = [
                'user_id' => auth()->id(),
                'code' => Order::generateCode(),
                'status' => Order::CREATED,
                'order_date' => $orderDate,
                'payment_due' => $paymentDue,
                'payment_status' => Order::UNPAID,
                'base_total_price' => $baseTotalPrice,
                'customer_first_name' => $token['username'],
                'customer_phone' => $token['phone'],
                'note' => $token['note'],
            ];
            if (!empty($token['reseller']) && $token['reseller'] === 'on') {
                $orderParams['customer_first_name'] = $token['customer_first_name']; // Simpan reseller name jika checkbox reseller dicentang
                $orderParams['customer_phone'] = $token['customer_phone']; // Simpan reseller phone jika checkbox reseller dicentang
            }
            
    
            $order = Order::create($orderParams);
    
            $cartItems = \Cart::getContent();
    
            if ($order && $cartItems) {
                foreach ($cartItems as $item) {
                    $itemDiscountAmount = 0;
                    $itemDiscountPercent = 0;
                    $itemBaseTotal = $item->quantity * $item->price;
                    $itemSubTotal = $itemBaseTotal - $itemDiscountAmount;
    
                    $product = $item->associatedModel;
    
                    $orderItemParams = [
                        'order_id' => $order->id,
                        'product_id' => $item->associatedModel->id,
                        'qty' => $item->quantity,
                        'base_price' => $item->price,
                        'base_total' => $itemBaseTotal,
                        'discount_amount' => $itemDiscountAmount,
                        'discount_percent' => $itemDiscountPercent,
                        'sub_total' => $itemSubTotal,
                        'name' => $item->name,
                        'weight' => $item->associatedModel->weight,
                    ];
    
                    $orderItem = OrderItem::create($orderItemParams);
    
                    if ($orderItem) {
                        $product = Product::findOrFail($product->id);
                        $product->quantity -= $item->quantity;
                        $product->save();
                    }
                }
            }
            return $order;
        });
    
        if (!isset($order)) {
            return redirect()->back()->with([
                'message' => 'something went wrong!',
                'alert-type' => 'danger'
            ]);
        }
    
        if ($request['cash'] === "on" && $request['cashless'] === "on") {
            return '<script>alert("Choose one payment only!!!");window.location.href="/orders/checkout"</script>';
        }
    
        if ($request['cash'] === "on") {
            \Cart::clear();
            $order->update(['payment_status' => 'unpaid']);
            return view('frontend.orders.cash', compact('order'));
        }
    
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
    
        $params = [
            'transaction_details' => [
                'order_id' => Str::random(15),
                'gross_amount' => $order->base_total_price,
            ],
            'customer_details' => [
                'name' => $request->username,
                'handphone' => $request->phone,
            ],
        ];
    
        $snapToken = \Midtrans\Snap::getSnapToken($params);
    
        return view('frontend.orders.confirmation', compact('snapToken', 'order'));
    }
    

    public function order_success($orderId)
    {
        $order = Order::find($orderId);
        $order->update(['payment_status' => 'paid']);
        \Cart::clear();
        return redirect()->route('homepage');
    }

    public function received($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('frontend.orders.received', compact('order'));
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->paginate(10);

        return view('frontend.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', auth()->id())->findOrFail($id);

        return view('frontend.orders.show', compact('order'));
    }
}