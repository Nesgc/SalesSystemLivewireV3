<?php

namespace App\Livewire;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class Reports extends Component
{

    use WithPagination;

    public $currentImage, $searchengine, $pageTitle, $componentName, $type, $value, $userId, $reportType, $dateFrom, $dateTo, $id, $details;

    public  $data, $sumDetails, $countDetails,
        $saleId, $datos;
    public function mount()
    {
        $this->componentName = 'Sales Report';
        $this->data = [];
        $this->details = [];
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->reportType = 1;
        $this->userId = 0;
        $this->saleId = 0;

        $this->dateTo = Carbon::now()->format('Y-m-d');
        $this->dateFrom = Carbon::now()->subDays(30)->format('Y-m-d');
    }
    public function render()
    {
        $this->SalesByDate();

        return view(
            'livewire.reports.reports',
            [
                'users' => User::orderBy('name', 'asc')->get(),
            ]
        );
    }

    public function SalesByDate()
    {
        if ($this->reportType == 1) {
            if (!$this->dateFrom || !$this->dateTo) {
                return;
            }
            $from = Carbon::parse($this->dateFrom)->startOfDay();
            $to = Carbon::parse($this->dateTo)->endOfDay();
        } else {
            $from = Carbon::now()->startOfDay();
            $to = Carbon::now()->endOfDay();
        }

        $query = Sale::join('users as u', 'u.id', 'sales.user_id')
            ->select('sales.*', 'u.name as user')
            ->whereBetween('sales.created_at', [$from, $to]);

        if ($this->userId != 0) {
            $query->where('user_id', $this->userId);
        }

        $this->data = $query->get();
    }


    public function getDetails($saleId)
    {
        $this->details = SaleDetail::join('products as p', 'p.id', 'sale_details.product_id')
            ->select('sale_details.id', 'sale_details.price', 'sale_details.quantity', 'p.name as product')
            ->where('sale_details.sale_id', $saleId)
            ->get();


        $suma = $this->details->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $this->sumDetails = $suma;
        $this->countDetails = $this->details->sum('quantity');
        $this->saleId = $saleId;

        $this->dispatch('show-modal', 'details loaded');
    }
}
