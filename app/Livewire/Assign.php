<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;


class Assign extends Component
{

    use WithPagination;
    use LivewireAlert;

    public $componentName, $role, $permisosSelected = [], $old_permissions = [];


    private $pagination = 10;


    public function mount()
    {
        $this->role = 'Elegir';
        $this->componentName = "Asignar Permisos";
    }
    public function render()
    {

        $permisos = Permission::select('name', 'id', DB::raw("0 as checked"))
            ->orderBy('name', 'asc')
            ->paginate($this->pagination);

        if ($this->role != 'Elegir') {
            $list = Permission::join('role_has_permissions as rp', 'rp.permission_id', 'permissions.id')
                ->where('role_id', $this->role)->pluck('permissions.id')->toArray();

            $this->old_permissions = $list;
        }
        if ($this->role != 'Elegir') {
            foreach ($permisos as $permiso) {
                $role = Role::find($this->role);
                $tienePermiso = $role->hasPermissionTo($permiso->name);
                if ($tienePermiso) {
                    $permiso->checked = 1;
                }
            }
        }
        return view('livewire.assign.assign', [
            'roles' => Role::orderBy('name', 'asc')->get(),
            'permisos' => $permisos
        ]);
    }

    protected $listeners = ['revokeall' => 'RemoveAll'];

    public function RemoveAll()
    {
        if ($this->role == 'Elegir') {
            $this->alert('warning', 'Selecciona un rol válido');
            return;
        }
        $role = Role::find($this->role);
        $role->syncPermissions([0]);
        $this->alert('warning', "Se revocaron todos los permisos al rol $role->name ");
    }

    public function SyncAll()
    {
        if ($this->role == 'Elegir') {
            $this->alert('warning', 'Selecciona un rol válido');
            return;
        }
        $role = Role::find($this->role);
        $permisos = Permission::pluck('id')->toArray();

        $role->syncPermissions($permisos);
        $this->alert('success', "Se sincronizaron todos los permisos al rol $role->name ");
    }

    public function SyncPermiso($state, $permisoName)
    {
        if ($this->role != 'Elegir') {
            $roleName = Role::find($this->role);
            if ($state) {
                $roleName->givePermissionTo($permisoName);
                $this->alert('success', 'Permiso asignado correctamente.');
            } else {
                $roleName->revokePermissionTo($permisoName);
                $this->alert('success', 'Permiso revocado correctamente.');
            }
        } else {
            $this->alert('warning', "Elige un rol válido");
        }
    }

    public function updatePermissions()
    {
        if ($this->role != 'Elegir') {
            $permisos = Permission::select('name', 'id', DB::raw("0 as checked"))
                ->orderBy('name', 'asc')
                ->paginate($this->pagination);

            $list = Permission::join('role_has_permissions as rp', 'rp.permission_id', 'permissions.id')
                ->where('role_id', $this->role)->pluck('permissions.id')->toArray();

            foreach ($permisos as $permiso) {
                if (in_array($permiso->id, $list)) {
                    $permiso->checked = 1;
                }
            }

            $this->permisos = $permisos;
        }
    }


    public function delete()  // Asegúrate de que el ID se pasa a esta función
    {
        $this->alert('warning', 'Are you sure you want to revoke all permissions?', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,  // Cambiado a false para que la alerta no desaparezca automáticamente
            'showConfirmButton' => true,
            'onConfirmed' => 'revokeall',  // Agregado un manejador para la confirmación
            'showCancelButton' => true,
            'onDismissed' => '',
            'showDenyButton' => false,
            'onDenied' => '',
            'timerProgressBar' => false,
            'width' => '400',
        ]);
    }
}
