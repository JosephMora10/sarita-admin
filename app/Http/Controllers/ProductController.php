<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(10);
        $categories = ProductCategory::all();
        return view('products.index', compact('products', 'categories'));
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
        $request->validate([
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'category_id' => 'required|exists:product_categories,id',
        ]);

        $product = new Product();
        $product->description=$request->description;
        $product->price=$request->price;
        $product->stock=$request->stock;
        $product->category_id=$request->category_id;
        $product->save();

        return redirect()->route('products')->with('success', 'Producto creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'category_id' => 'required|exists:product_categories,id',
        ]);

        $product = Product::findOrFail($id);
        $product->description=$request->description;
        $product->price=$request->price;
        $product->stock=$request->stock;
        $product->category_id=$request->category_id;
        $product->save();

        return redirect()->route('products')->with('success', 'Producto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products')->with('success', 'Producto eliminado correctamente');
    }
}
