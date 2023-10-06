<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class Products extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $currentImage, $searchengine, $selected_id, $pageTitle, $componentName, $barcode, $price, $stock, $alerts, $cost, $categories, $category, $category_id;

    #[Rule('nullable|image|max:3024')] // 1MB Max
    public $image;
    public $isEditMode = false;
    public $isOpen = 0;
    public $path;

    #[Rule('required|min:3|unique:categories,name,{$this->selected_id}')]
    public $name;

    public function mount()
    {
        $this->pageTitle = 'Listing';
        $this->componentName = 'Products';
    }
    public function render()
    {

        $products = Product::with('category')->get();
        $categories = Category::with('products')->get();

        if ($this->searchengine == "") {
            $products = Product::paginate(10);
        } else {
            $products = Product::where('name', 'like', '%' . $this->searchengine . '%')
                ->orWhere('barcode', 'like', '%' . $this->searchengine . '%')->paginate(10);
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
        $this->currentImage = $record->image;  // Imagen actual, no la sobrescribe con la nueva imagen.

    }


    public function Store()
    {
        $this->isEditMode = false;

        // Validar si la imagen no es obligatoria o hacer validaciones personalizadas
        $this->validate([
            'name' => 'required|string|max:255', // Solo como ejemplo, ajusta según tus necesidades
            'image' => 'nullable|image|max:2048' // Haciendo la imagen opcional
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

        session()->flash('success', 'Category created successfully.');
        $this->reset('name', 'image', 'barcode', 'price', 'stock', 'alerts', 'cost', 'category_id');
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
            session()->flash('success', 'Post updated successfully.');

            $this->resetUI();
            $this->dispatch('alert', 'El post se actualizó satisfactoriamente');
        }
    }

    public function Delete($id)
    {
        Product::find($id)->delete();
        session()->flash('success', 'Post deleted successfully.');
        $this->reset('name', 'image', 'barcode', 'price', 'stock', 'alerts', 'cost', 'category_id');
    }


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
