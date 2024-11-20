<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Penjualan;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjualan = DB::table('sales')
            ->join('product', 'sales.product_id', '=', 'product.product_id')
            ->select('sales.*', 'product.product_name')
            ->get();
        $products  = Product::all();
        
        $title = 'Delete Data!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('penjualan.index', compact('penjualan'), compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $penjualan = Penjualan::all();
        return view('penjualan.create', compact('products'), compact('penjualan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'qty' => 'required|numeric|min:1|max:' . Product::findOrFail($request->product_id)->qty,
            'price' => 'required|numeric',
            'total' => 'required|numeric',
        ], [
            'product_id.required' => 'Nama produk harus diisi',
            'qty.required' => 'Jumlah harus diisi',
            'qty.numeric' => 'Jumlah harus berupa angka',
            'qty.min' => 'Jumlah minimal 1',
            'qty.max' => 'Jumlah tidak boleh melebihi sisa stok: ' . Product::findOrFail($request->product_id)->qty,
            'price.required' => 'Harga harus diisi',
            'price.numeric' => 'Harga harus berupa angka',
            'total.required' => 'Total harus diisi',
            'total.numeric' => 'Total harus berupa angka',
        ]);

        // Simpan data penjualan
        $penjualan = new Penjualan();
        $penjualan->customer_name = $request->customer_name;
        $penjualan->product_id = $request->product_id;
        $penjualan->qty = $request->qty;
        $penjualan->price = $request->price;
        $penjualan->total = $request->total;
        $penjualan->save();

        // Kurangi qty di table product
        $products = Product::findOrFail($request->product_id);
        $products->qty = $products->qty - $request->qty;
        $products->save();
        return redirect()->route('penjualan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $sales_id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $sales_id)
    {
        $products = Product::all();
        $penjualan = Penjualan::findOrFail($sales_id);
        return view('penjualan.edit', compact('products'), compact('penjualan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $sales_id)
    {
        $penjualan = Penjualan::findOrFail($sales_id);

        $request->validate([
            'customer_name' => 'required',
            'qty' => 'required|numeric|min:1|max:' . ($penjualan->product_id == $request->product_id ? $penjualan->qty + Product::findOrFail($request->product_id)->qty : Product::findOrFail($request->product_id)->qty),
            'price' => 'required|numeric',
            'total' => 'required|numeric',
        ], [
            'customer_name.required' => 'Nama customer harus diisi',
            'qty.required' => 'Jumlah harus diisi',
            'qty.numeric' => 'Jumlah harus berupa angka',
            'qty.min' => 'Jumlah minimal harus 1',
            'qty.max' => 'Jumlah maximal harus ' . ($penjualan->product_id == $request->product_id ? $penjualan->qty + Product::findOrFail($request->product_id)->qty : Product::findOrFail($request->product_id)->qty),
            'price.required' => 'Harga harus diisi',
            'price.numeric' => 'Harga harus berupa angka',
            'total.required' => 'Total harus diisi',
            'total.numeric' => 'Total harus berupa angka',
        ]);

        // Kembalikan qty produk ke stok sebelum diubah
        $product = Product::findOrFail($penjualan->product_id);
        $product->qty += $penjualan->qty;
        $product->save();

        // Update penjualan
        $penjualan->customer_name = $request->customer_name;
        $penjualan->product_id = $request->product_id;
        $penjualan->qty = $request->qty;
        $penjualan->price = $request->price;
        $penjualan->total = $request->total;
        $penjualan->save();

        // Kurangi qty di table product berdasarkan update
        $product = Product::findOrFail($request->product_id);
        $product->qty -= $request->qty;
        $product->save();
        return redirect()->route('penjualan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $sales_id)
    {
        $penjualan = Penjualan::findOrFail($sales_id);
        $product = Product::findOrFail($penjualan->product_id);
        $product->qty += $penjualan->qty;
        $product->save();
        $penjualan->delete();
        return redirect()->route('penjualan.index');
    }
}

