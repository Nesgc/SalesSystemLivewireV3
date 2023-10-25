<?php

namespace App\Livewire;

use App\Models\Denomination;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;



class Pos extends Component
{
    use LivewireAlert;

    public $total, $itemsQuantity, $denominations, $efectivo, $change, $componentName, $products, $barcode, $selected_id;

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


    public function ScanCode()
    {
        $barcode = $this->barcode; // Obtener el valor del código de barras del modelo de Livewire

        // Validar si el código de barras está presente
        if (empty($barcode)) {
            $this->alert('warning', 'El código de barras está vacío');
            return;
        }

        // Buscar el producto por el código de barras
        $product = Product::where('barcode', $barcode)->first();

        // Validar si el producto fue encontrado
        if (!$product) {
            $this->alert('warning', 'El producto no fue encontrado');
            return;
        }

        // Validar si el producto ya está en el carrito
        if ($this->InCart($product->id)) {
            $this->increaseQty($product->id);
            $this->alert('success', 'Cantidad actualizada');
            return;
        }

        // Validar si hay stock disponible
        if ($product->stock < 1) {
            $this->alert('warning', 'Stock insuficiente');
            return;
        }

        // Agregar el producto al carrito
        Cart::add($product->id, $product->name, $product->price, 1, $product->image);

        // Actualizar el total y la cantidad de ítems
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        // Enviar una notificación de éxito
        $this->alert('success', 'Producto agregado');
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
            $this->alert('no-stock', 'Stock insuficiente');
            return;
        }

        Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->alert('success', $title);
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
                $this->alert('no-stock', 'Stock insuficiente :/');
                return;
            }
        }

        $this->removeItem($productId);
        if ($cant > 0) {
            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->alert('success', $title);
        }
    }
    public function deletes($id)  // Asegúrate de que el ID se pasa a esta función
    {
        $this->selected_id = $id;  // Almacena el ID para usarlo en la confirmación
        $this->alert('warning', 'Are you sure you want to delete this product?', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,  // Cambiado a false para que la alerta no desaparezca automáticamente
            'showConfirmButton' => true,
            'onConfirmed' => 'removeItem',  // Agregado un manejador para la confirmación
            'showCancelButton' => true,
            'onDismissed' => '',
            'showDenyButton' => false,
            'onDenied' => '',
            'timerProgressBar' => false,
            'width' => '400',
        ]);
    }

    public function removeItem()
    {
        Cart::remove($this->selected_id);
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->alert('success', 'Producto eliminado');
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
        $this->alert('success', 'Cantidad actualizada');
    }

    public function clearCart()
    {
        Cart::clear();
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->alert('success', 'Carro vacío');
    }

    public function saveSale()
    {
        if ($this->total <= 0) {
            $this->alert('warning', 'AGREGA PRODUCTOS A LA VENTA');
            return;
        }
        if ($this->efectivo <= 0) {
            $this->alert('warning', 'INGRESA EL EFECTIVO');
            return;
        }
        if ($this->total > $this->efectivo) {
            $this->alert('warning', 'EL EFECTIVO DEBE SER MAYOR O IGUAL AL TOTAL');
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

            $this->alert('success', 'Venta registrada con éxito');
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
