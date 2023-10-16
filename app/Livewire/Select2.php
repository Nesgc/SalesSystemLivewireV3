<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class Select2 extends Component
{

    public $products, $productSelectedId, $productSelectedName;

    public function mount()
    {
        $this->products = [];
    }

    public function render()
    {
        $this->products = Product::orderBy('name', 'asc')->get();
        return view('livewire.select2');
    }
}
