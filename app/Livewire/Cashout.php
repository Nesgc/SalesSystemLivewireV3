<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Livewire\Component;

class Cashout extends Component
{
    public $user_id, $searchengine, $total, $items, $row, $selected_id, $details;
    public function render()
    {
        return view(
            'livewire.cashout.cashout',
            [
                'users' => User::orderBy('name', 'asc')->get(),
                'sale' => Sale::orderBy('items', 'asc')->get(),
                'saledetail' => SaleDetail::orderBy('price', 'asc')->get(),
                'products' => Product::orderBy('name', 'asc')->get()
            ]
        );
    }
}
