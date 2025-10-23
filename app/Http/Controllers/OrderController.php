<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('paymentMethod', 'seller')->get();
        $paymentMethods = PaymentMethod::all();
        $sellers = User::all();
        return view('orders.index', compact('orders', 'paymentMethods', 'sellers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paymentMethods = PaymentMethod::all();
        $products = Product::all();
        $sellers = User::all();
        return view('orders.create', compact('paymentMethods', 'products', 'sellers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $itemsQty = 0;
        $subTotal = 0;
        $discount = 0;

        $orderItems = [];

        foreach ($validated['products'] as $productData) {
            $product = Product::find($productData['product_id']);
            $quantity = $productData['quantity'];
            $price = $product->price;
            $itemDiscount = 0;
            $itemTotal = ($price * $quantity) - $itemDiscount;
            
            $itemsQty += $quantity;
            $subTotal += $price * $quantity;
            
            $orderItems[] = [
                'product_id' => $productData['product_id'],
                'quantity' => $quantity,
                'price' => $price,
                'discount' => $itemDiscount,
                'total' => $itemTotal,
            ];
        }

        $total = $subTotal - $discount;

        $order = Order::create([
            'items_qty' => $itemsQty,
            'sub_total' => $subTotal,
            'discount' => $discount,
            'total' => $total,
            'payment_method_id' => $validated['payment_method_id'],
            'seller_id' => auth()->id(),
        ]);

        foreach ($orderItems as $item) {
            $order->orderDetails()->create([
                'sale_order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'discount' => $item['discount'],
                'total' => $item['total'],
            ]);
        }

        return redirect()->route('orders')->with('success', 'Pedido creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['orderDetails.product', 'paymentMethod', 'seller'])
            ->findOrFail($id);
        
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::findOrFail($id);
        $paymentMethods = PaymentMethod::all();
        return view('orders.edit', compact('order', 'paymentMethods'));
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
        //
    }
}
