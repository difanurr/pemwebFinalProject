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
        // return response()->json(['message' => 'Data customer berhasil diperbarui'], 200);
    }

    public function delete($id)
    {
        $customer = Customer::where('id_customer', $id)->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer tidak ditemukan'], 404);
        }

        // Hapus data customer
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