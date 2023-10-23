<?php

namespace App\Livewire;

use App\Models\Denomination;
use App\Models\Product;
use Livewire\Component;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\SaleDetail;
use Exception;
use Illuminate\Support\Facades\Redirect;


class Pos extends Component
{

    public $total, $itemsQuantity, $denominations = [], $efectivo, $change;

    public function mount()
    {
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
    }
    public function render()
    {

        $this->denominations = Denomination::all();

        return view('livewire.pos.pos', [
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
        dd($barcode);

        //dd($barcode); //** LLega el barcode OK!!
        $product = Product::where('barcode', $barcode)->first();

        //dd($product); //Producto encontrado!
        if ($product == null || empty($product)) {
            $this->dispatch('scan-notfound', 'El producto no fue encontrado');
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
            /*$carro = Cart::getContent();
            dd($carro);*/

            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();

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

    public function increaseQty($productId, $cant = 1)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if ($exist)
            $title = 'Cantidad actualizada';
        else
            $title = 'Producto agregada';

        if ($product->stock < ($cant + $exist->quantity)) {
            $this->dispatch('no-stock', 'Stock insuficiente');
            return;
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
            $title = 'Cantidad actualizada';
        else
            $title = 'Producto agregado';

        if ($exist) {
            if ($product->stock < $cant) {
                $this->dispatch('no-stock', 'Stock insuficiente :/');
                return;
            }
        }

        $this->removeItem($productId);
        if ($cant > 0) {
            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->dispatch('scan-ok', $title);
        }
    }

    public function removeItem($productId)
    {
        Cart::remove($productId);
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->dispatch('scan-ok', 'Producto eliminado');
    }

    public function decreaseQty($productId)
    {
        $item = Cart::get($productId);
        Cart::remove($productId);
        $newQty = ($item->quantity) - 1;
        if ($newQty > 0)
            Cart::add($item->id, $item->name, $item->price, $newQty);
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
        $this->dispatch('scan-ok', 'Carro vacío');
    }

    public function saveSale()
    {
        if ($this->total <= 0) {
            $this->dispatch('sale-error', 'AGREGA PRODUCTOS A LA VENTA');
            return;
        }
        if ($this->efectivo <= 0) {
            $this->dispatch('sale-error', 'INGRESA EL EFECTIVO');
            return;
        }
        if ($this->total > $this->efectivo) {
            $this->dispatch('sale-error', 'EL EFECTIVO DEBE SER MAYOR O IGUAL AL TOTAL');
            return;
        }
        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'total' => $this->total,
                'items' => $this->itemsQuantity,
                'cash'  => $this->efectivo,
                'change'  => $this->change,
                'user_id' => Auth()->user()->id
            ]);
            if ($sale) {
                $items = Cart::getContent();
                foreach ($items as $item) {
                    SaleDetail::create([
                        'price'          => $item->price,
                        'quantity'       => $item->quantity,
                        'product_id'  => $item->id,
                        'sale_id' => $sale->id,
                    ]);

                    //update STOCK
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

            $this->dispatch('sale-ok', 'Venta registrada con éxito');
            $this->dispatch('print-ticket', $sale->id);
        } catch (Exception $e) {
            DB::rollBack();
            $this->dispatch('sale-error', $e->getMessage());
        }
    }

    public function printTicket($sale)
    {
        return Redirect::To("print://$sale->id");
    }
}
