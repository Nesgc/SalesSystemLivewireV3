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


        return view('livewire.roles.roles', compact('roles', 'users'));
    }

    public function create()
    {
        $this->reset('name', 'guard_name');

        $this->resetUI();
    }
    public function CreateRole()
    {

        // Validar si la imagen no es obligatoria o hacer validaciones personalizadas
        $this->validate([
            'name' => 'required|string|max:255', // Solo como ejemplo, ajusta según tus necesidades
            'guard_name' => 'nullable|max:2048' // Haciendo la imagen opcional
        ]);




        Role::create([
            'name' => $this->name,
            'guard_name' => $this->guard_name,
        ]);

        $this->alert('success', 'Created Succesfully');
        $this->reset('name', 'guard_name');
        $this->dispatch('role-added', 'se registo el rol con exito');
        $this->resetUI();
    }

    public function Edit($id)
    {
        $record = Role::find($id, ['id', 'name', 'guard_name']);
        $this->name = $record->name;
        $this->guard_name = $record->guard_name;
        $this->selected_id = $record->id;
        $this->dispatch('show-modal', 'Show Modal!');
    }

    public function UpdateRoles()
    {
        $rules = ['roleName' => 'required|min:2|unique:roles,name'];

        $messages = [
            'roleName.required' => 'The name is required',
            'roleName.unique' => 'The name already exists',
            'roleName.min' => 'The name must be at least 2 characters',
        ];

        $this->validate($rules, $messages);

        $role = Role::find($this->roleName);
        $this->name = $role->name;
        $this->guard_name = $role->guard_name;
        $this->selected_id = $role->selected_id;
        $this->dispatch('role-update', 'Se actualizo con exito');
    }

    public function UpdateRole()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'guard_name' => 'nullable',  // Agrega tus propias reglas de validación aquí
            // ... otras reglas de validación
        ]);

        $role = Role::find($this->selected_id);


        $role->update([
            'name' => $this->name,
            'guard_name' => $this->guard_name,
        ]);

        $this->alert('success', 'Updated Succesfully');
        $this->resetUI();
        $this->dispatch('role-updated', 'Se actualizo con exito');
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
            $this->alert('danger', 'Cant eliminate this rol because it has assignated permissions');
            return;
        }

        Role::find($this->selected_id)->delete();
        $this->alert('success', 'The role has been eliminated.');
    }

    public function AssignRoles()
    {
        if ($this->userSelected > 0) {
            $user = User::find($this->selected_id);
            if ($user) {
                $user->syncRoles($rolesList);
                $this->alert('success', 'Roles assigns correctly');
                $this->resetInput();
            }
        }
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
