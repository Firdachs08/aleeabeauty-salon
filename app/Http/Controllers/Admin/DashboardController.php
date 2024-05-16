<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        $product_count = Product::count();
        $booking_count = Booking::count();
        $service_count = Service::count();
        $order = Order::count();
        
        return view('admin.dashboard', compact('product_count','booking_count', 'service_count','order'));
    }
}
