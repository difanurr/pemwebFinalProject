<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Detail;
use Illuminate\Http\Request;

class DetailController extends Controller
{

    public function show()
    {
        $barang = Barang::all();
        $detail = Detail::all();
        return view('pages.detail', compact('detail', 'barang'));
    }

    public function update(Request $request, $id_detail_transaksi)
    {
        $request->validate([
            'id_transaksi' => 'required|numeric',
            'id_barang' => 'required',
            'jumlah_beli' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'total_beli' => 'required|numeric',
        ]);

        $detail = Detail::where('id_detail_transaksi', $id_detail_transaksi)
            ->first();

        if (!$detail) {
            return response()->json(['message' => 'Detail transaksi tidak ditemukan'], 404);
        }

        $detail->id_transaksi = $request->input('id_transaksi');
        $detail->id_barang = $request->input('id_barang');
        $detail->jumlah_beli = $request->input('jumlah_beli');
        $detail->harga_beli = $request->input('harga_beli');
        $detail->total_beli = $request->input('total_beli');
        $detail->save();

        return redirect()->back();
    }

    public function delete($id_detail_transaksi)
    {
        $detail = Detail::where('id_detail_transaksi', $id_detail_transaksi)
            ->first();

        if (!$detail) {
            return response()->json(['message' => 'Detail tidak ditemukan'], 404);
        }

        $detail->delete();

        return redirect()->back();
    }

    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'id_transaksi' => 'required|numeric',
            'id_barang' => 'required',
            'jumlah_beli' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'total_beli' => 'required|numeric',
        ]);

        Detail::create($validatedData);

        return redirect()->back();
    }

}
