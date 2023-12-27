<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;

class ProductController extends Controller {

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            DB::beginTransaction();
            Product::create([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'hsn' => $request->hsn,
                'price' => $request->price,
            ]);

            DB::commit();
            return redirect()->route('product.index')->with('success', 'Product Created Successfully..!!');
        } catch (\Exception $e)
        {
            Log::error([
                'error' => [
                    'location' => 'CabController@update',
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            ]);
            DB::rollBack();
            return redirect()->route('product.index')->with('failure', 'Product Not Created');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            Product::where('id', $id)->update([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'hsn' => $request->hsn,
                'price' => $request->price,
            ]);

            DB::commit();

            return redirect()->route('product.index')->with('success', 'Product Updated Successfully..!!');
        } catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->route('product.index')->with('success', 'Product Not Created');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        DB::beginTransaction();
        try {
            $product->delete();
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('success', 'Product not deleted');
        }
        DB::commit();

        return redirect()->back()->with('success', 'Product deleted Successfully');
    }

    public function getProducts()
    {
        $products = Product::get();

        return response()->json($products);
    }
}
