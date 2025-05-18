<?php

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('webhook', function (Request $request) {
  
    $order = Order::find($request->get('order_id'));

    if(!$order) {
        return response()->json([
            'status' => 'error',
            'message' => 'Order not found',
        ]);
    }

    $order->status = $request->get('status');
    $order->save();
    $order->refresh();

    if($order->status == 'canceled') {
        $items = $order->items;
        foreach($items as $item) {
            Product::find($item->product_id)->stock()->increment('quantity', $item->quantity);
        }        
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Order status updated',
    ]);      
})->name('webhook');