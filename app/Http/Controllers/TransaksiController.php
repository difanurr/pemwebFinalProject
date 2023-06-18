<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function show()
    {
        $customer = Customer::all();
        $transaksi = Transaksi::all();
        return view('pages.transaksi', compact('transaksi', 'customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date_format:Y-m-d',
            'id_customer' => 'required',
        ]);

        $transaksi = Transaksi::where('id_transaksi', $id)->first();

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $transaksi->tanggal = $request->input('tanggal');
        $transaksi->id_customer = $request->input('id_customer');
        $transaksi->save();

        return response()->json(['message' => 'Data berhasil diperbarui']);

    }

    public function delete($id)
    {
        $transaksi = Transaksi::where('id_transaksi', $id)->first();

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $transaksi->delete();

        return redirect()->back();
    }

    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required|date_format:Y-m-d',
            'id_customer' => 'required',
        ]);

        Transaksi::create($validatedData);

        return redirect()->back();
    }

}
