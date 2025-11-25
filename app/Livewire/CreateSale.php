<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\DailySale;
use Illuminate\Support\Facades\DB;

class CreateSale extends Component
{
    public $search = '';
    public $cart = [];
    public $orderTotal = 0;
    public $loadingProductId = null;

    public function mount()
    {
        $this->cart = [];
        $this->orderTotal = 0;
    }

    public function addProduct($productId)
    {
        $this->loadingProductId = $productId;

        $product = Product::findOrFail($productId);

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            $this->cart[$productId] = [
                'id' => $product->id,
                'description' => $product->description,
                'unit_price' => $product->price,
                'quantity' => 1,
            ];
        }

        $this->calculateTotal();
        $this->loadingProductId = null;

        session()->flash('message', 'Producto agregado exitosamente');
    }

    public function removeProduct($productId)
    {
        if (isset($this->cart[$productId])) {
            unset($this->cart[$productId]);
            $this->calculateTotal();
        }
    }

    public function updateQuantity($productId, $quantity)
    {
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity'] = max(1, intval($quantity));
            $this->calculateTotal();
        }
    }

    public function calculateTotal()
    {
        $this->orderTotal = collect($this->cart)
            ->sum(fn($item) => $item['unit_price'] * $item['quantity']);
    }

    public function finalizeOrder()
    {
        if (empty($this->cart)) {
            session()->flash('message', 'No hay productos en la orden.');
            return;
        }

        DB::beginTransaction();

        try {
            $sale = DailySale::create([
                'seller_id' => auth()->id(),
                'items_qty' => collect($this->cart)->sum('quantity'),
                'total_amount' => $this->orderTotal,
                'is_completed' => true,
            ]);

            foreach ($this->cart as $item) {
                $sale->details()->create([
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['unit_price'] * $item['quantity'],
                ]);
            }

            DB::commit();

            $this->cart = [];
            $this->orderTotal = 0;
            
            session()->flash('message', 'Orden finalizada y guardada correctamente.');
            return redirect()->route('sales.create');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'Error al guardar la orden: ' . $e->getMessage());
            return redirect()->route('sales.create');
        }
    }

    public function render()
    {
        $products = Product::when($this->search, function ($query) {
                return $query->where('description', 'like', '%' . $this->search . '%');
            })->get();

        return view('livewire.create-sale', [
            'products' => $products,
        ]);
    }
}
