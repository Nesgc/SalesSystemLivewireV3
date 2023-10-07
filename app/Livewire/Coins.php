<?php

namespace App\Livewire;

use App\Models\Denomination;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class Coins extends Component
{

    use WithFileUploads;
    use WithPagination;


    public $currentImage, $searchengine, $pageTitle, $componentName, $type, $value;
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
        $this->componentName = 'Denomination';
    }

    public function render()
    {


        $denominations = $this->searchengine
            ? Denomination::where('type', 'like', '%' . $this->searchengine . '%')
            ->orWhere('value', 'like', '%' . $this->searchengine . '%')->paginate(10)
            : Denomination::paginate(10);

        return view('livewire.coins', compact('denominations'));
    }
    public function create()
    {
        $this->isEditMode = false; // Asegurarse de que está en modo "crear"
        $this->reset('type', 'image', 'value');

        $this->resetUI();
    }

    public function Edit($id)
    {
        $this->isEditMode = true;
        $record = Denomination::find($id, ['id', 'type', 'value', 'image']);
        $this->type = $record->type;
        $this->value = $record->value;
        $this->selected_id = $record->id;
        $this->currentImage = $record->image;  // Imagen actual, no la sobrescribe con la nueva imagen.

    }


    public function Store()
    {
        $this->isEditMode = false;

        // Validar si la imagen no es obligatoria o hacer validaciones personalizadas
        $this->validate([
            'type' => 'required|string|max:255', // Solo como ejemplo, ajusta según tus necesidades
            'image' => 'nullable|image|max:2048' // Haciendo la imagen opcional
        ]);

        // Verificar si la imagen está presente
        $imagePath = $this->image
            ? $this->image->store('denominations')
            : 'null';  // puedes ajustar esto según tus necesidades

        Denomination::create([
            'type' => $this->type,
            'value' => $this->value,
            'image' => $imagePath
        ]);

        session()->flash('success', 'Denomination created successfully.');
        $this->reset('type', 'image', 'value');
    }




    public function Update()
    {
        $this->validate([
            'type' => 'required|string|max:255',
            'value' => 'required',  // Agrega tus propias reglas de validación aquí
            // ... otras reglas de validación
        ]);

        if (!$this->selected_id) {
            // Imprime un error o maneja esta situación según sea necesario
            session()->flash('error', 'No se puede actualizar: ID no válido.');
            return;
        }

        $denomination = Denomination::find($this->selected_id);

        if (!$denomination) {
            // Imprime un error o maneja esta situación según sea necesario
            session()->flash('error', 'No se puede actualizar: Denominación no encontrada.');
            return;
        }

        $denomination->update([
            'type' => $this->type,
            'value' => $this->value,
            'image' => $this->image ? $this->image->store('denominations') : $denomination->image,
        ]);

        session()->flash('success', 'Denominación actualizada con éxito.');
        $this->resetUI();
    }




    public function resetUI()
    {
        $this->type = '';
        $this->value = '';
        $this->image = null;
        $this->currentImage = null; // Agregado para manejar la imagen actual en la edición.
        $this->selected_id = 0;
    }
}
