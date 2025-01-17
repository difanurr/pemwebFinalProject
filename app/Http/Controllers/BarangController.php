<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Detail;
use Illuminate\Http\Request;

class BarangController extends Controller
{

    public function show()
    {
        $barang = Barang::all();
        return view('pages.barang', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'harga' => 'required|numeric',
        ]);

        $barang = Barang::where('id_barang', $id)->first();

        if (!$barang) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        $barang->nama_barang = $request->input('nama_barang');
        $barang->harga = $request->input('harga');
        $barang->save();

        return redirect()->back();
    }

    public function delete($id)
    {
        $barang = Barang::where('id_barang', $id)->first();

        if (!$barang) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        if ($barang ->isBeingUsed()) {
            $errorMessage = 'Barang dengan ID ' . $id . ' tidak dapat dihapus karena masih digunakan di tabel Detail Transaksi';
            return back()->with('error', $errorMessage);
        }

        $barang->delete();

        return redirect()->back();
    }

    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'id_barang' => 'required',
            'nama_barang' => 'required',
            'harga' => 'required',
        ]);

        Barang::create($validatedData);

        return redirect()->back();
    }
}
