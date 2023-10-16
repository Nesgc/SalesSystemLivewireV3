<?php

namespace App\Livewire;

use App\Models\Denomination;
use App\Models\Product;
use Livewire\Component;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use DB;
use App\Models\Sale;
use App\Models\SaleDetail;
use Exception;
use Redirect;


class Pos extends Component
{

    public $total, $itemsQuantity, $denominations, $efectivo, $change, $componentName;

    public function mount()
    {
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->componentName = 'Sales';
    }
    public function render()
    {
        $this->denominations = Denomination::all();

        return view('livewire.pos', [
            'denominations' => Denomination::orderBy('value', 'desc')->get(),
            'cart' => Cart::getContent()->sortBy('name'),
        ]);
    }

    public function ACash($value)
    {
        $this->efectivo += ($value == 0 ? $this->total : $value);
        $this->change = ($this->efectivo - $this->total);
    }

    protected $listeners = [
        'scan-code' => 'ScanCode',
        'removeItem' => 'removeItem',
        'clearCart' => 'clearCart',
        'saveSale' => 'saveSale'
    ];

    public function ScanCode($barcode, $cant = 1)
    {
        $product = Product::where('barcode', $barcode)->first();

        if ($product == null || empty($empty)) {
            $this->dispatch('scan-notfound', 'El product no esta registrado');
        } else {
            if ($this->InCart($product->id)) {
                $this->increaseQty($product->id);
                return;
            }
            if ($product->stock < 1) {
                $this->dispatch('no-stock', 'Stock insuficiente');
                return;
            }

            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
            $this->total = Cart::getTotal();
            $this->dispatch('scan-ok', 'Producto agregado');
        }
    }

    public function InCart($productId)
    {
        $exist = Cart::get($productId);
        if ($exist)
            return true;
        else
            return false;
    }

    function increaseQty($productId, $cant = 1)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if ($exist)
            $title = 'Cantidad Actualizada';
        else
            $title = 'Product Agregado';
        if ($exist) {
            if ($product->stock < ($cant + $exist->quantity)) {
                $this->dispatch('no-stock', 'Stock Insuficiente');
                return;
            }
        }
        Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->dispatch('scan-ok', $title);
    }

    public function updateQty($productId, $cant = 1)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if ($exist)
            $title = 'Cantidad Actualizada';
        else
            $title = 'Product Agregado';


        if ($exist) {
            if ($product->stock < $cant) {
                $this->dispatch('no-stock', 'Stock Insuficiente');
                return;
            }
        }
        $this->removeItem($productId);
        if ($cant > 0) {
            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();

            $this->dispatch('scan-ok', $title);
        } else {
            $this->dispatch('scan-ok', 'Cantidad tiene que ser mayor a 0');
        }
    }
    public function removeItem($productId)
    {
        Cart::remove($productId);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->dispatch('scan-ok', 'Producto Eliminado');
    }
    public function decreaseQty($productId)
    {
        $item = Cart::get($productId);
        Cart::remove($productId);

        $newQty = ($item->quantity) - 1;
        if ($newQty > 0)
            Cart::add($item->id, $item->name, $item->price, $newQty, $item->attributes[0]);


        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->dispatch('scan-ok', 'Cantidad actualizada');
    }

    public function clearCart()
    {
        Cart::clear();
        $this->efectivo = 0;
        $this->change = 0;

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->dispatch('scan-ok', 'Empty Cart');
    }

    public function saveSale()
    {
        if ($this->total <= 0) {
            $this->dispatch('sale-error', 'Add available products');
            return;
        }
        if ($this->efectivo <= 0) {
            $this->dispatch('sale-error', 'Add cash');
            return;
        }
        if ($this->change > $this->efectivo) {
            $this->dispatch('sale-error', 'Cash must be more or equal to the total');
            return;
        }
        DB::beginTransaction();

        try {
            $sale = Sale::create([
                'total' => $this->total,
                'items' => $this->itemsQuantity,
                'cash' => $this->efectivo,
                'change' => $this->change,
                'user_id' => $this->Auth()->user()->id
            ]);

            if ($sale) {
                $items = Cart::getContent();
                foreach ($items as $item) {
                    SaleDetail::create([
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'product_id' => $item->id,
                        'sale_id' => $item->id,
                    ]);

                    $product = Product::find($item->id);
                    $product->stock = $product->stock - $item->quantity;
                    $product->save();
                }
            }

            DB::commit();

            Cart::clear();
            $this->efectivo = 0;
            $this->change = 0;
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();

            $this->dispatch('sale-ok', 'Successful sale');
            $this->dispatch('print-ticket', $sale->id);
        } catch (Exception $e) {
            DB::rollBack();
            $this->dispatch('sale-error', $e->getMessage());
        }
    }
    public function printTicket($sale)
    {
        return Redirect::to("print://$sale->id");
    }
}
