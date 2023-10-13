<?php

namespace App\Livewire;

use App\Models\Denomination;
use Livewire\Component;

class Pos extends Component
{

    public $total, $cart = [], $itemsQuantity, $denominations, $efectivo, $change, $componentName;

    public function mount()
    {
        $this->componentName = 'Sales';
    }
    public function render()
    {
        $this->denominations = Denomination::all();

        return view('livewire.pos');
    }
}
