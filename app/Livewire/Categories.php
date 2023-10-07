<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;


class Categories extends Component
{
    use WithFileUploads;
    use WithPagination;


    public $currentImage, $searchengine, $pageTitle, $componentName;
    #[Rule('nullable|image|max:3024')] // 1MB Max
    public $image;
    public $isEditMode = false;
    public $path;

    #[Rule('required')]
    public $selected_id;

    #[Rule('required|min:3|unique:categories,name,{$this->selected_id}')]
    public $name;

    public function mount()
    {
        $this->pageTitle = 'Listing';
        $this->componentName = 'Categories';
    }

    public function render()
    {
        $categories = $this->searchengine
            ? Category::where('name', 'like', '%' . $this->searchengine . '%')->paginate(10)
            : Category::paginate(4);


        return view('livewire.categories', compact('categories'));
    }

    public function create()
    {
        $this->isEditMode = false; // Asegurarse de que está en modo "crear"
        $this->reset('name', 'image');

        $this->resetUI();
    }

    public function Edit($id)
    {
        $this->isEditMode = true;
        $record = Category::find($id, ['id', 'name', 'image']);
        $this->name = $record->name;
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
            ? $this->image->store('categories')
            : 'null';  // puedes ajustar esto según tus necesidades

        Category::create([
            'name' => $this->name,
            'image' => $imagePath
        ]);

        session()->flash('success', 'Category created successfully.');
        $this->reset('name', 'image');
        $this->closeModal();
    }




    public function Update()
    {
        $this->validate();

        if ($this->selected_id) {
            $category = Category::find($this->selected_id);

            $data = [
                'name' => $this->name,
            ];

            if ($this->image) {
                $data['image'] = $this->image->store('categories');
            }

            $category->update($data);
            session()->flash('success', 'Post updated successfully.');

            $this->resetUI();
            $this->dispatch('alert', 'El post se actualizó satisfactoriamente');
        }
    }

    public function Delete($id)
    {
        Category::find($id)->delete();
        session()->flash('success', 'Post deleted successfully.');
        $this->reset('name', 'image');
    }



    public function resetUI()
    {
        $this->name = '';
        $this->image = null;
        $this->currentImage = null; // Agregado para manejar la imagen actual en la edición.
        $this->selected_id = 0;
    }
}
