<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Products extends Component
{
    use WithFileUploads;
    use WithPagination;
    use LivewireAlert;


    public $currentImage, $searchengine, $selected_id, $pageTitle, $componentName, $barcode, $price, $stock, $alerts, $cost, $categories, $category, $category_id;

    #[Rule('nullable|image|max:3024')] // 1MB Max
    public $image;
    public $isEditMode = false;

    public $path;

    #[Rule('required|min:3|unique:categories,name,{$this->selected_id}')]
    public $name;

    public function mount()
    {
        $this->pageTitle = 'Listing';
        $this->componentName = 'Products';
        $this->categories = Category::all();
    }
    public function render()
    {

        // Obtén los productos
        $products = Product::with('category')->paginate(10);

        // Obtén las categorías - Asegurándonos de que esto se hace correctamente
        $categories = Category::all();  // Esto obtendrá todas las categorías.

        // Verifica si $categories tiene datos
        if ($categories->isEmpty()) {
            // Esto imprimirá un mensaje en tu consola si $categories está vacío
            error_log('No categories found!');
        }

        if ($this->searchengine == "") {
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->orderBy('products.name', 'asc')->paginate(10);
        } else {
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->where('products.name', 'like', '%' . $this->searchengine . '%')
                ->orWhere('products.barcode', 'like', '%' . $this->searchengine . '%')
                ->orWhere('c.name', 'like', '%' . $this->searchengine . '%')
                ->orderBy('products.name', 'asc')
                ->paginate(10);
        }

        return view('livewire.products', compact('products', 'categories'));
    }

    public function create()
    {
        $this->isEditMode = false; // Asegurarse de que está en modo "crear"
        $this->reset('name', 'image', 'barcode', 'price', 'stock', 'alerts', 'cost', 'category_id');

        $this->resetUI();
    }

    public function Edit($id)
    {
        $this->isEditMode = true;
        $record = Product::find($id, ['id', 'name', 'image', 'barcode', 'price', 'stock', 'alerts', 'cost', 'category_id']);
        $this->name = $record->name;
        $this->barcode = $record->barcode;
        $this->price = $record->price;
        $this->stock = $record->stock;
        $this->alerts = $record->alerts;
        $this->cost = $record->cost;
        $this->selected_id = $record->id;
        $this->category_id = $record->category_id;
        $this->currentImage = $record->image;  // Imagen actual, no la sobrescribe con la nueva imagen.
        $this->dispatch('show-modal', 'Show Modal');
    }


    public function Store()
    {
        $this->isEditMode = false;

        // Validar si la imagen no es obligatoria o hacer validaciones personalizadas
        $this->validate([
            'name' => 'required|string|max:255', // Solo como ejemplo, ajusta según tus necesidades
            'image' => 'nullable|image|max:2048', // Haciendo la imagen opcional
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'barcode' => 'required',
            'alerts' => 'required',
            'category_id' => 'required|not_in:Elegir',
        ]);

        // Verificar si la imagen está presente
        $imagePath = $this->image
            ? $this->image->store('products')
            : 'null';  // puedes ajustar esto según tus necesidades

        Product::create([
            'name' => $this->name,
            'image' => $imagePath,
            'barcode' => $this->barcode,
            'price' => $this->price,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'cost' => $this->cost,
            'category_id' => $this->category_id,

        ]);


        $this->reset('name', 'image', 'barcode', 'price', 'stock', 'alerts', 'cost', 'category_id');
        $this->alert('success', 'Created Succesfully');

        $this->dispatch('product-added', 'Producto Registrado');
    }


    public function Update()
    {
        $this->validate();

        if ($this->selected_id) {
            $product = Product::find($this->selected_id);


            $data = [
                'name' => $this->name,
                'barcode' => $this->barcode,
                'price' => $this->price,
                'stock' => $this->stock,
                'alerts' => $this->alerts,
                'cost' => $this->cost,
                'category_id' => $this->category_id,

            ];

            if ($this->image) {
                $data['image'] = $this->image->store('products');
            }

            $product->update($data);
            $this->alert('success', 'Updated Succesfully');

            $this->resetUI();
            $this->dispatch('product-updated', 'Producto Actualizado');
        }
    }

    public function delete($id)  // Asegúrate de que el ID se pasa a esta función
    {
        $this->selected_id = $id;  // Almacena el ID para usarlo en la confirmación
        $this->alert('warning', 'Are you sure you want to delete?', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,  // Cambiado a false para que la alerta no desaparezca automáticamente
            'showConfirmButton' => true,
            'onConfirmed' => 'confirmedDeletion',  // Agregado un manejador para la confirmación
            'showCancelButton' => true,
            'onDismissed' => '',
            'showDenyButton' => false,
            'onDenied' => '',
            'timerProgressBar' => false,
            'width' => '400',
        ]);
    }



    public function confirmedDeletion()
    {
        // Mensaje de depuración para verificar que este método se está llamando
        logger('confirmedDeletion called, ID: ' . $this->selected_id);

        $product = Product::find($this->selected_id);
        if ($product) {
            $product->delete();
            $this->alert('success', 'The product has been eliminated.');
        } else {
            $this->alert('error', 'La denominación no se pudo encontrar.');
        }
    }

    protected $listeners = [
        'confirmedDeletion'
    ];



    public function resetUI()
    {
        $this->name = '';
        $this->barcode = '';
        $this->price = '';
        $this->stock = '';
        $this->alerts = '';
        $this->cost = '';
        $this->category_id = '';
        $this->image = null;
        $this->currentImage = null; // Agregado para manejar la imagen actual en la edición.
        $this->selected_id = 0;
    }
}
