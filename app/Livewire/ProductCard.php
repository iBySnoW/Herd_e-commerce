<?php

namespace App\Livewire;

use Livewire\Component;

class ProductCard extends Component
{
    public $product;

    public function mount($product)
    {
        $this->product = $product;

    }

    public function addToCart($id)
    {
        $this->dispatch('add-product', $id);
    }

    public function render()
    {
        return view('livewire.product-card');
    }
}
