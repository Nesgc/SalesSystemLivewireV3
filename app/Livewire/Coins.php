<?php

namespace App\Livewire;

use App\Models\Denomination;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;


class Coins extends Component
{

    use WithFileUploads;
    use WithPagination;
    use LivewireAlert;


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
        $record = Denomination::find($id, ['id', 'type', 'value', 'image']);
        $this->type = $record->type;
        $this->value = $record->value;
        $this->selected_id = $record->id;
        $this->currentImage = $record->image;  // Imagen actual, no la sobrescribe con la nueva imagen.
        $this->dispatch('show-modal', 'Show Modal!');
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

        $this->alert('success', 'Created Succesfully');
        $this->reset('type', 'image', 'value');
        $this->dispatch('denomination-added', 'Denominacion Registrada!');
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

        $this->alert('success', 'Updated Succesfully');
        $this->resetUI();
        $this->dispatch('denomination-updated', 'Denominacion Actualizada!');
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

        $denomination = Denomination::find($this->selected_id);
        if ($denomination) {
            $denomination->delete();
            $this->alert('success', 'The denomination has been eliminated.');
        } else {
            $this->alert('error', 'La denominación no se pudo encontrar.');
        }
    }

    protected $listeners = [
        'confirmedDeletion'
    ];

    public function Delete2($id)
    {
        $record = Denomination::find($id, ['id', 'type', 'value', 'image']);
        $this->type = $record->type;
        $this->value = $record->value;
        $this->selected_id = $record->id;
        $this->currentImage = $record->image;  // Imagen actual, no la sobrescribe con la nueva imagen.

    }
    public function deletePost($id)
    {
        $this->selected_id = $id;
        $this->dispatch('deletePost'); // Esto es solo un ejemplo, podrías necesitar algo diferente aquí.
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
