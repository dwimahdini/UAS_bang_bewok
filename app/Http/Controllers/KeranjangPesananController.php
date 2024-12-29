<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Produk;
use App\Models\KeranjangPesanan;
use App\Models\Order;

class KeranjangPesananController extends Controller
{
    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'productId' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        KeranjangPesanan::create([
            'produk_id' => $validated['productId'],
            'jumlah' => $validated['quantity'],
            'status' => 'menunggu',
        ]);

        return response()->json(['success' => true]);
    }

    public function index()
    {
        // Fetch the cart items with their current status
        $keranjangPesanan = KeranjangPesanan::with('produk')->get();  
        return view('keranjangPesanan', compact('keranjangPesanan'));
    }

    public function batalPesanan($id)
    {
        $item = KeranjangPesanan::find($id);

        if ($item) {
            $item->delete(); // Hapus item
            return response()->json(['message' => 'Pesanan berhasil dibatalkan.'], 200);
        }

        return response()->json(['message' => 'Item tidak ditemukan.'], 404);
    }

    // Process all orders from the cart
    public function processAllOrders(Request $request)
    {
        try {
            $orderIds = $request->input('order_ids');

            // Your logic to process the orders goes here

            return response()->json(['message' => 'Pesanan berhasil diproses.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan pada server.'], 500);
        }
    }

    public function approveOrder($id)
    {
        // Logic to approve a specific order by ID
        $order = KeranjangPesanan::find($id);
        if ($order) {
            // Update the order status to 'accepted' or similar
            $order->status = 'accepted';
            $order->save();
            return response()->json(['message' => 'Pesanan diterima.'], 200);
        }
        return response()->json(['error' => 'Pesanan tidak ditemukan.'], 404);
    }

    // Reject an order (if needed)
    public function rejectOrder($id)
    {
        // Logic to reject a specific order by ID
        $order = KeranjangPesanan::find($id);
        if ($order) {
            // Update the order status to 'rejected' or similar
            $order->status = 'rejected';
            $order->save();
            return response()->json(['message' => 'Pesanan ditolak.'], 200);
        }
        return response()->json(['error' => 'Pesanan tidak ditemukan.'], 404);
    }

    public function viewCart()
    {
        // Fetch the cart items with their current status
        $keranjangPesanan = KeranjangPesanan::with(['status', 'produk'])->get();
        return view('keranjangPesanan', compact('keranjangPesanan'));
    }

    public function approveOrders(Request $request)
    {
        $orderIds = $request->input('order_ids');
        // Update the status in the database
        Order::whereIn('id', $orderIds)->update(['status' => 'processed']);
        return response()->json(['message' => 'Pesanan berhasil diproses.']);
    }

    public function rejectOrders(Request $request)
    {
        $orderIds = $request->input('order_ids');
        // Update the status in the database
        Order::whereIn('id', $orderIds)->update(['status' => 'rejected']);
        return response()->json(['message' => 'Pesanan berhasil ditolak.']);
    }
}