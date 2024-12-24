<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PesananMasukController extends Controller
{
    public function index()
    {
        $orders = Order::with('produk')->get();
        return view('pesananMasuk', compact('orders'));
    }
}
