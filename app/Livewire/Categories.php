<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Categories extends Component
{
    use WithFileUploads;
    use WithPagination;
    use LivewireAlert;


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
            : Category::paginate(10);


        return view('livewire.category.categories', compact('categories'));
    }

    public function create()
    {
        $this->isEditMode = false; // Asegurarse de que está en modo "crear"
        $this->reset('name', 'image');

        $this->resetUI();
    }

    public function Edit($id)
    {
        $record = Category::find($id, ['id', 'name', 'image']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->currentImage = $record->image;  // Imagen actual, no la sobrescribe con la nueva imagen.
        $this->dispatch('show-modal', 'Show Modal!');
    }


    public function Store()
    {

        // Validar si la imagen no es obligatoria o hacer validaciones personalizadas
        $this->validate([
            'name' => 'required|string|max:255|min:3', // Solo como ejemplo, ajusta según tus necesidades
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

        $this->reset('name', 'image');
        $this->dispatch('category-added', 'Categoría Registrada!');
        $this->alert('success', 'Categoria creada!');
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

            $this->resetUI();
            $this->dispatch('category-updated', 'Categoría Actualizada!');
            $this->alert('success', 'Categoría Actualizada!');
        }
    }

    public function Delete($id)  // Asegúrate de que el ID se pasa a esta función
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

        $category = Category::find($this->selected_id);
        if ($category) {
            $category->delete();
            $this->alert('success', 'Succesfully Eliminated ' . $category->name);
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
        $this->image = null;
        $this->currentImage = null; // Agregado para manejar la imagen actual en la edición.
        $this->selected_id = 0;
    }
}
