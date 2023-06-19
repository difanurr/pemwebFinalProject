<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller {

    public function show() {
        $customer = Customer::all();
        return view('pages.customer', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_customer' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
        ]);

        $customer = Customer::where('id_customer', $id)->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer tidak ditemukan'], 404);
        }

        $customer->nama_customer = $request->input('nama_customer');
        $customer->no_telp = $request->input('no_telp');
        $customer->alamat = $request->input('alamat');
        $customer->save();

        return redirect()->back();
    }

    public function delete($id)
    {
        $customer = Customer::where('id_customer', $id)->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer tidak ditemukan'], 404);
        }

        if ($customer->isBeingUsed()) {
            $errorMessage = 'Customer dengan ID ' . $id . ' tidak dapat dihapus karena masih digunakan di tabel Transaksi';
            return back()->with('error', $errorMessage);
        }

        $customer->delete();

        return redirect()->back();
    }


    public function add(Request $request) {
        $validateData = $request->validate([
            'id_customer' => 'required',
            'nama_customer' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
        ]);

        Customer::create($validateData);

        return redirect()->back();
    }
}