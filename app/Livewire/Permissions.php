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

    public  $componentName, $pageTitle, $permissionName, $selected_id, $searchengine, $PermissionsList;
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

        if (strlen($this->searchengine) > 0)
            $permisos = Permission::where('name', 'like', '%' . $this->searchengine . '%')->paginate($this->pagination);
        else
            $permisos = Permission::orderBy('name', 'asc')->paginate($this->pagination);


        return view('livewire.permissions.permissions', [
            'permisos' => $permisos
        ]);
    }
    public function create()
    {
        $this->reset('name');

        $this->resetUI();
    }
    public function Store()
    {
        $rules = ['permissionName' => 'required|min:2|unique:permissions,name'];

        $messages = [
            'permissionName.required' => 'Elnombre del permiso es requerido',
            'permissionName.min'      => 'El nombre del permiso debe tener al menos 2 carateres',
            'permissionName.unique'   => 'El permiso ya existe'
        ];

        $this->validate($rules, $messages);

        Permission::create([
            'name' => $this->permissionName
        ]);

        $this->dispatch('permiso-added', 'Se registró el permiso con exito');
        $this->alert('success', 'Created Succesfully');

        $this->resetUI();
    }

    public function Edit($id)
    {
        $this->resetValidation();
        $record = Permission::find($id, ['id', 'name']);
        $this->selected_id = $record->id;
        $this->permissionName = $record->name;
        $this->dispatch('show-modal', 'Show Modal!');
    }


    public function Update()
    {
        $rules = ['permissionName' => "required|min:2|unique:permissions,name, {$this->selected_id}"];

        $messages = [
            'permissionName.required' => 'Elnombre del permiso es requerido',
            'permissionName.min'      => 'El nombre debe tener al menos 3 carateres',
            'permissionName.unique'   => 'El permiso ya existe'
        ];
        $this->validate($rules, $messages);

        $permiso = Permission::find($this->selected_id);
        $permiso->name = $this->permissionName;
        $permiso->save();

        $this->dispatch('permiso-updated', 'Se actualizó el permiso con éxito');
        $this->alert('success', 'Updated Succesfully');

        $this->resetUI();
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
        $permission = Permission::find($this->selected_id);

        if (!$permission) {
            $this->alert('warning', 'Permission not found.');
            return;
        }

        $rolesCount = $permission->roles ? $permission->roles->count() : 0; // Asegurarse de que roles no es null antes de contar

        if ($rolesCount > 0) {
            $this->alert('warning', 'Cannot delete this permission because it has assigned roles.');
            return;
        }

        $permission->delete();
        $this->alert('success', 'The Permission has been deleted.');
    }



    protected $listeners = [
        'confirmedDeletion'
    ];

    public function resetUI()
    {

        $this->name = '';
        $this->searchengine = '';

        $this->selected_id = 0;

        $this->resetValidation();
    }
}
