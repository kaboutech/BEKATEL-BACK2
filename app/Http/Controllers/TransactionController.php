<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionOrder;
use App\Models\Order;
use App\Models\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('orders')->get();

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $orders = Order::where('customer_id', auth()->id())
            ->where('order_status_id', 1)
            ->whereDoesntHave('transactions')
            ->get();

        return view('transactions.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $customer_id = $request->input('customer_id');
        $orders = Order::where('customer_id', $customer_id)
            ->where('order_status_id', 1) // Delivered orders
            ->whereNull('paid_at') // Not paid yet
            ->get();
        
        $total_amount = 0;
        foreach ($orders as $order) {
            $city_id = $order->receiver->city_id;
            $city_price = City::find($city_id)->price;
            $total_amount += $order->total_price - $city_price;
        }
    
        // Store the transaction in the database
        $transaction = new Transaction;
        $transaction->customer_id = $customer_id;
        $transaction->city_id = $city_id;
        $transaction->amount = $total_amount;
        $transaction->save();
        
        // Store the transaction details in the database
        foreach ($orders as $order) {
            $transactionOrder = new TransactionOrder;
            $transactionOrder->transaction_id = $transaction->id;
            $transactionOrder->order_id = $order->id;
            $transactionOrder->save();
        }
    
        return response()->json(['message' => 'Transaction created successfully.']);
    }
    
}