<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::latest();
        


        if ($request->input('status') && in_array($request->input('status'), array_keys(Order::STATUSES))) {
            $orders = $orders->where('status', '=', $request->input('status'));
        }

        $startDate = $request->input('start');
        $endDate = $request->input('end');

        if ($startDate && !$endDate) {
            return redirect('admin/orders');
        }

        if (!$startDate && $endDate) {
            return redirect('admin/orders');
        }

        if ($startDate && $endDate) {
            if (strtotime($endDate) < strtotime($startDate)) {
                return redirect('admin/orders');
            }

            $orders = $orders->whereRaw("DATE(order_date) >= ?", $startDate)
                ->whereRaw("DATE(order_date) <= ? ", $endDate);
        }

        $orders = $orders->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }
    public function savePayment(Request $request, $orderId)
{
    $order = Order::find($orderId);

    if (!$order) {
        return redirect()->back()->with([
            'message' => 'Order not found!',
            'alert-type' => 'error'
        ]);
    }
    
    $order->update(['payment_status' => 'paid', 'total_paid' => $request->total_paid]);
    $changeAmount = $request->total_paid - $order->base_total_price;
    $order->change_amount = $changeAmount;
    $order->save();
    
    // Simpan total dibayarkan dalam session
    session(['total_paid' => $request->total_paid]);

    return redirect()->route('admin.orders.show', $order)->with([
        'message' => 'Payment status updated to paid!',
        'alert-type' => 'success',
        'total_paid' => $request->total_paid,
    ]);
}

    public function markAsPaid(Request $request, $orderId)
{
    $order = Order::find($orderId);

    if (!$order) {
        return redirect()->back()->with([
            'message' => 'Order not found!',
            'alert-type' => 'error'
        ]);
    }
    
    $order->update(['payment_status' => 'paid', 'total_paid' => $request->total_paid]);
    $changeAmount = $request->total_paid - $order->base_total_price;
    $order->change_amount = $changeAmount;
    $order->save();
    
    // Simpan total dibayarkan dalam session
    session(['total_paid' => $request->total_paid]);

    return redirect()->route('admin.orders.show', $order)->with([
        'message' => 'Payment status updated to paid!',
        'alert-type' => 'success',
        'total_paid' => $request->total_paid,
    ]);
}

    
    // ...
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {

        OrderItem::where('order_id', $order->id)->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')->with([
            'message' => 'success deleted !',
            'alert-type' => 'danger'
        ]);;
    }

    public function cancel($id)
    {
        $order = Order::where('id', $id)
            ->whereIn('status', [Order::CREATED, Order::CONFIRMED])
            ->firstOrFail();

        return view('admin.orders.cancel', compact('order'));
    }

    public function cancelUpdate(Request $request, $id)
    {
        $request->validate(
            [
                'cancellation_note' => 'required|max:255',
            ]
        );

        $order = Order::findOrFail($id);

        $cancelOrder = \DB::transaction(
            function () use ($order, $request) {
                $params = [
                    'status' => Order::CANCELLED,
                    'cancelled_by' => auth()->id(),
                    'cancelled_at' => now(),
                    'cancellation_note' => $request->cancellation_note,
                ];

                if ($cancelOrder = $order->update($params) && $order->orderItems->count() > 0) {
                    foreach ($order->orderItems as $item) {
                        $product = Product::findOrFail($item->product_id);
                        $product->quantity += $item->qty;
                        $product->save();
                    }
                }

                return $cancelOrder;
            }
        );

        return redirect()->route('admin.orders.index')->with([
            'message' => 'success cancelled !',
            'alert-type' => 'danger'
        ]);;
    }

    public function complete(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if (!$order->isDelivered()) {
            return redirect()->route('admin.orders.index');
        }

        $order->status = Order::COMPLETED;
        $order->approved_by = auth()->id();
        $order->approved_at = now();

        if ($order->save()) {
            return redirect()->route('admin.orders.index')->with([
                'message' => 'completed order !',
                'alert-type' => 'success'
            ]);;
        }
    }
}
