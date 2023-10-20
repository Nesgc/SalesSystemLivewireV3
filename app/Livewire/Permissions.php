<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Livewire\Attributes\Rule;
use DB;


class Permissions extends Component

{

    use WithPagination;
    use LivewireAlert;

    public  $componentName, $pageTitle, $PermissionName, $selected_id, $searchengine, $PermissionsList;
    private $pagination = 10;

    #[Rule('required|min:3|unique:permissions,name,{$this->selected_id}')]
    public $name;
    #[Rule('nullable')]
    public $guard_name;

    public function mount()
    {
        $this->pageTitle = 'Listing';
        $this->componentName = 'Permissions';
    }
    public function render()
    {

        $permissions = $this->searchengine
            ? Permission::where('name', 'like', '%' . $this->searchengine . '%')
            ->orWhere('id', 'like', '%' . $this->searchengine . '%')->paginate(10)
            : Permission::paginate(10);

        return view('livewire.permissions.permissions', compact('permissions'));
    }
    public function create()
    {
        $this->reset('name', 'guard_name');

        $this->resetUI();
    }
    public function Store()
    {

        // Validar si la imagen no es obligatoria o hacer validaciones personalizadas
        $this->validate();




        Permission::create([
            'name' => $this->name,
            'guard_name' => $this->guard_name,
        ]);

        $this->alert('success', 'Created Succesfully');
        $this->reset('name', 'guard_name');
        $this->dispatch('Permission-added', 'se registo el rol con exito');
        $this->resetUI();
    }

    public function Edit($id)
    {
        $this->resetValidation();
        $record = Permission::find($id, ['id', 'name', 'guard_name']);
        $this->name = $record->name;
        $this->guard_name = $record->guard_name;
        $this->selected_id = $record->id;
        $this->dispatch('show-modal', 'Show Modal!');
    }


    public function Update()
    {
        $this->validate();


        $Permission = Permission::find($this->selected_id);


        $Permission->update([
            'name' => $this->name,
            'guard_name' => $this->guard_name,
        ]);
        $this->alert('success', 'Updated Succesfully');
        $this->resetUI();
        $this->dispatch('Permission-updated', 'Se actualizo con exito');
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


        $rolesCount = Permission::find($this->selected_id)->getname->count();
        if ($rolesCount > 0) {
            $this->alert('danger', 'Cant eliminate this rol because it has assignated permissions');
            return;
        }

        Permission::find($this->selected_id)->delete();
        $this->alert('success', 'The Permission has been eliminated.');
    }



    protected $listeners = [
        'confirmedDeletion'
    ];

    public function resetUI()
    {

        $this->name = '';
        $this->guard_name = '';
        $this->searchengine = '';

        $this->selected_id = 0;

        $this->resetValidation();
    }
}
