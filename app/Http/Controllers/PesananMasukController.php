<?php

namespace App\Http\Controllers;

use App\Models\KeranjangPesanan;
use App\Models\RiwayatPesanan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PesananMasukController extends Controller
{
    public function index()
    {
        $keranjang = KeranjangPesanan::where('status_id', 1)->with('produk')->get();
        return view('pesananMasuk', compact('keranjang'));
    }

    public function updateStatus(Request $request)
    {
        $orderIds = $request->input('order_ids');
        $action = $request->input('action');

        if ($action === 'terima') {
            // Update status to 'disetujui'
            KeranjangPesanan::whereIn('id', $orderIds)->update(['status' => 'disetujui']);
        } else {
            // Update status to 'ditolak' for those not selected
            KeranjangPesanan::whereNotIn('id', $orderIds)->update(['status' => 'ditolak']);
        }

        return response()->json(['message' => 'Status updated successfully']);
    }

    public function processOrders(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:keranjang_pesanan,id',
        ], [
            'order_ids.*.exists' => 'One or more selected order IDs are invalid. Please check your selection.',
        ]);

        $orderIds = $request->input('order_ids');
        KeranjangPesanan::whereIn('id', $orderIds)->update(['status' => 'processed']);

        // Ensure that the status is set to 'menunggu' when added to the cart
        KeranjangPesanan::whereIn('id', $orderIds)->update(['status' => 'menunggu']);

        return response()->json(['message' => 'Orders processed successfully.'], 200);
    }

    public function approveOrders(Request $request): JsonResponse
    {
        $orderIds = $request->input('order_ids'); // Expecting an array of order IDs

        // Update the status of the specified orders to 'approved'
        KeranjangPesanan::whereIn('id', $orderIds)->update(['status_id' => 3]);

        // Fetch the updated orders
        $data = KeranjangPesanan::whereIn('id', $orderIds)->get();

        // Log each order in the history table
        foreach ($data as $item) {
            RiwayatPesanan::create([
                'order_id' => $item->produk_id,
                'status_id' => $item->status_id,
                'jumlah' => $item->jumlah,
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function rejectOrders(Request $request)
    {
        $orderIds = $request->input('order_ids'); // Expecting an array of order IDs

        // Update the status of the specified orders to 'rejected'
        KeranjangPesanan::whereIn('id', $orderIds)->update(['status' => 'rejected']);

        return response()->json(['success' => true]);
    }
}
