<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::all();
        return view('product.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $sales_id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $sales_id)
    {
        //
    }
    public function getPriceById($product_id)
    {
        $product = Product::where('product_id', $product_id)->first();

        if ($product) {
            return response()->json(['price' => $product->price]);
        } else {
            return response()->json(['price' => 0], 404); // Jika produk tidak ditemukan, kembalikan harga 0 atau error
        }
    }

    public function updateQtyStock(Request $request, $product_id) {
        $product = Product::findOrFail($product_id);
        $product->qty = $request->input('qty');
        $product->save();
        return redirect()->route('product.index');
    }
}
