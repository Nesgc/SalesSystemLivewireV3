<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use App\Models\User;
use DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class Roles extends Component
{
    use WithPagination;
    use LivewireAlert;




    public  $componentName, $pageTitle, $roleName, $selected_id, $searchengine, $guard_name, $rolesList;
    private $pagination = 5;

    public $role = 'Elegir';  // Default value
    public $permisosChecked = [];  // To keep track of checked permissions

    public $name;
    public function mount()
    {
        $this->pageTitle = 'Listing';
        $this->componentName = 'Roles';
    }
    public function render()
    {

        // Obtén las categorías - Asegurándonos de que esto se hace correctamente
        $users = User::all();  // Esto obtendrá todas las categorías.


        $roles = $this->searchengine
            ? Role::where('name', 'like', '%' . $this->searchengine . '%')
            ->orWhere('id', 'like', '%' . $this->searchengine . '%')->paginate(10)
            : Role::paginate(10);

        $permisos = Permission::orderBy('name', 'asc')->paginate($this->pagination);


        return view('livewire.roles.roles', compact('roles', 'users', 'permisos'));
    }

    public function updatedRole()
    {
        // Reset checked permissions when role changes
        $this->permisosChecked = [];
        if ($this->role != 'Elegir') {
            $role = Role::find($this->role);
            $this->permisosChecked = $role->permissions->pluck('id')->toArray();
        }
    }

    public function syncPermiso()
    {
        if ($this->role != 'Elegir') {
            $role = Role::find($this->role);
            $role->permissions()->sync($this->permisosChecked);
        }
    }


    public function create()
    {
        $this->reset('name');

        $this->resetUI();
    }
    public function CreateRole()
    {
        $rules = ['roleName' => 'required|min:2|unique:roles,name'];

        $messages = [
            'roleName.required' => 'Elnombre del rol es requerido',
            'roleName.min'      => 'El nombre debe tener al menos 3 carateres',
            'roleName.unique'   => 'El rol ya existe'
        ];

        $this->validate($rules, $messages);

        Role::create([
            'name' => $this->roleName
        ]);

        $this->dispatch('role-added', 'Se registró el rol con exito');
        $this->resetUI();
    }

    public function PermModal(Role $role)
    {
        //$role = Role::find($id);
        $this->selected_id = $role->id;
        $this->roleName = $role->name;
        $this->permisosChecked = $role->permissions->pluck('id')->toArray();  // Populate permisosChecked

        $this->dispatch('show-modals', 'Show modal');
    }
    public function Edit(Role $role)
    {
        //$role = Role::find($id);
        $this->selected_id = $role->id;
        $this->roleName = $role->name;

        $this->dispatch('show-modal', 'Show modal');
    }

    public function UpdateRole()
    {
        $rules = ['roleName' => "required|min:2|unique:roles,name, {$this->selected_id}"];

        $messages = [
            'roleName.required' => 'Elnombre del rol es requerido',
            'roleName.min'      => 'El nombre debe tener al menos 3 carateres',
            'roleName.unique'   => 'El rol ya existe'
        ];
        $this->validate($rules, $messages);

        $role = Role::find($this->selected_id);
        $role->name = $this->roleName;
        $role->save();

        $this->dispatch('role-updated', 'Se actualizó el rol con éxito');
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


        $permissionsCount = Role::find($this->selected_id)->permissions->count();
        if ($permissionsCount > 0) {
            $this->alert('warning', 'Cant eliminate this rol because it has assignated permissions');
            return;
        }

        Role::find($this->selected_id)->delete();
        $this->alert('success', 'The role has been eliminated.');
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
    }
}
