<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\DailySale;
use App\Models\DailySaleDetail;

class DailySaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = DailySale::paginate(10);
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::with('category')->get()->groupBy('category.description');
        $sellers = User::all();
        $paymentMethods = PaymentMethod::all();
        return view('sales.create', compact('products', 'sellers', 'paymentMethods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'items_qty' => 'required|integer|min:1',
            'product_price' => 'required|numeric|min:0',
            'seller_id' => 'required|exists:users,id'
        ]);

        $sale = new DailySale();
        $sale->product_id=$request->product_id;
        $sale->items_qty=$request->items_qty;
        $sale->product_price=$request->product_price;
        $sale->seller_id=$request->seller_id;
        $sale->save();

        return redirect()->back()->with('success', 'Producto agregado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sales = DailySaleDetail::with('product')->where('daily_sale_id', $id)->get();
        $sale = DailySale::find($id);
        return view('sales.show', compact('sales', 'sale'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale = DailySale::where('id', $id)->first();
        $sale->delete();
        return redirect()->back()->with('success', 'Venta eliminada exitosamente');
    }
}
