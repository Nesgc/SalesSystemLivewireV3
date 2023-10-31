<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Cashout extends Component
{
    public $user_id, $searchengine, $total, $items, $row, $selected_id, $details, $fromDate, $toDate, $sales, $saled;

    public function mount()
    {
        $this->fromDate = Carbon::now()->subDays(30)->toDateString();
        $this->toDate = Carbon::now()->toDateString();
        $this->user_id = 0;
        $this->total = 0;
        $this->sales = [];
        $this->details = [];
    }
    public function render()
    {
        return view(
            'livewire.cashout.cashout',
            [
                'users' => User::orderBy('name', 'asc')->get(),

            ]
        );
    }

    public function Consult()
    {

        $fi = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
        $ff = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';

        $this->sales = Sale::whereBetween('created_at', [$fi, $ff])
            ->where('status', 'PAID')
            ->where('user_id', $this->user_id)
            ->get();

        $this->total = $this->sales ? $this->sales->sum('total') : 0;
        $this->items = $this->sales ? $this->sales->sum('items') : 0;
    }

    public function viewDetails(Sale $sale)
    {
        $fi = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
        $ff = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';


        $this->details = Sale::join('sale_details as d', 'd.sale_id', 'sales.id')
            ->join('products as p', 'p.id', 'd.product_id')
            ->select('d.sale_id', 'p.name as product', 'd.quantity', 'd.price')
            ->whereBetween('sales.created_at', [$fi, $ff])
            ->where('sales.status', 'PAID')
            ->where('sales.user_id', $this->user_id)
            ->where('sales.id', $sale->id)
            ->get();


        $this->dispatch('show-modal', 'open modal');
    }

    public function resetUI()
    {
        $this->fromDate = Carbon::now()->subDays(30)->toDateString();
        $this->toDate = Carbon::now()->toDateString();
        $this->total = 0;
        $this->sales = [];
        $this->details = [];
    }


    public function Print()
    {
    }
}
