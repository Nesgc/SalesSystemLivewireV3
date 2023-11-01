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
        $this->reportType = 0;
        $this->userId = 0;
        $this->saleId = 0;
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

        if ($this->reportType == 0)  //VENTAS DEL DIA
        {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        } else {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59';
        }

        if ($this->reportType == 1 && ($this->dateFrom == '' || $this->dateTo == '')) {
            return;
        }

        $query = Sale::join('users as u', 'u.id', 'sales.user_id')
            ->select('sales.*', 'u.name as user')
            ->whereBetween('sales.created_at', [$from, $to]);

        if ($this->userId != 0) {
            $query->where('user_id', $this->userId);
        }

        //return $query->paginate($this->pagination);
        //$this->data = $query->get();
        //$this->data = $query->paginate($this->pagination);

        if ($this->userId == 0) {

            $this->data = Sale::join('users as u', 'u.id', 'sales.user_id')
                ->select('sales.*', 'u.name as user')
                ->whereBetween('sales.created_at', [$from, $to])
                ->get();
        } else {
            $this->data = Sale::join('users as u', 'u.id', 'sales.user_id')
                ->select('sales.*', 'u.name as user')
                ->whereBetween('sales.created_at', [$from, $to])
                ->where('user_id', $this->userId)
                ->get(); //->paginate($this->pagination);
        }
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
