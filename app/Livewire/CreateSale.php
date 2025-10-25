<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\DailySale;

class CreateSale extends Component
{
    public $search = '';
    public $salesCount = 0;
    public $loadingProductId = null;

    public function mount()
    {
        $this->salesCount = DailySale::where('seller_id', auth()->id())->count();
    }

    public function addProduct($productId)
    {
        $this->loadingProductId = $productId;

        $product = Product::findOrFail($productId);

        DailySale::create([
            'product_id' => $product->id,
            'items_qty' => 1,
            'product_price' => $product->price,
            'seller_id' => auth()->id(),
        ]);

        $this->salesCount++;
        $this->loadingProductId = null;
        
        session()->flash('message', 'Producto agregado exitosamente');
    }

    public function render()
    {
        $products = Product::when($this->search, function($query) {
                return $query->where('description', 'like', '%' . $this->search . '%');
            })
            ->get()
            ->groupBy('category.description');

        return view('livewire.create-sale', [
            'products' => $products
        ]);
    }
}
