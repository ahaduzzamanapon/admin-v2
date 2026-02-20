<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index()
    {
        return view('shop.order_tracking');
    }

    public function track(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
        ]);

        $order = Order::where('order_number', $request->order_number)
            ->with(['items.product.primaryImage'])
            ->first();

        if (!$order) {
            return back()->with('error', 'No order found with that order number. Please check and try again.')->withInput();
        }

        return view('shop.order_tracking', compact('order'));
    }
}
