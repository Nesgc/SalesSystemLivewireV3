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

    public $tempPermissions = [];

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
            $this->alert('warning', 'Selecciona un rol valido!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
                'width' => '400',
                'text' => '',
            ]);
            return;
        }
        $role = Role::find($this->role);
        $permisos = Permission::pluck('id')->toArray();

        $role->syncPermissions($permisos);
        $this->alert('success', "Se sincronizaron todos los permisos al rol $role->name ");
    }

    public function togglePermission($state = null, $permisoName = null)
    {
        if ($this->role != 'Elegir') {
            $role = Role::find($this->role);

            // Asignar o revocar el permiso si se proporciona un nombre de permiso
            if ($permisoName) {
                if ($state) {
                    $role->givePermissionTo($permisoName);
                    $this->alert('success', 'Permiso asignado correctamente.');
                } else {
                    $role->revokePermissionTo($permisoName);
                    $this->alert('success', 'Permiso revocado correctamente.');
                }
            }
            $this->render();

            // Obtener y actualizar la lista de permisos
            $permisos = Permission::select('name', 'id', DB::raw("0 as checked"))
                ->orderBy('name', 'asc')
                ->paginate($this->pagination);

            $list = $role->permissions->pluck('id')->toArray();

            foreach ($permisos as $permiso) {
                if (in_array($permiso->id, $list)) {
                    $permiso->checked = 1;
                }
            }

            $this->permisos = $permisos;
        } else {
            $this->alert('warning', "Elige un rol válido");
        }
    }

    public function toggleTempPermission($permisoId)
    {
        if (in_array($permisoId, $this->tempPermissions)) {
            // Si el permiso ya está en la lista, quítalo
            $this->tempPermissions = array_filter($this->tempPermissions, function ($value) use ($permisoId) {
                return $value != $permisoId;
            });
        } else {
            // Si el permiso no está en la lista, agrégalo
            $this->tempPermissions[] = $permisoId;
        }
    }

    public function savePermissions()
    {
        $role = Role::find($this->role);

        // Verificar si el rol tiene un nombre
        if (empty($role->name)) {
            // Opcional: Mostrar una alerta al usuario
            $this->alert('warning', 'El rol no es valido.');
            return;  // Salir de la función si el nombre del rol está vacío
        }

        foreach ($this->tempPermissions as $permisoId) {
            $permiso = Permission::find($permisoId);
            $tienePermiso = $role->hasPermissionTo($permiso->name);
            if ($tienePermiso) {
                $role->revokePermissionTo($permiso->name);
            } else {
                $role->givePermissionTo($permiso->name);
            }
        }

        session()->flash('status', 'Role ' . $role->name . ' successfully updated ');

        $this->redirect('/assign');
    }




    public function delete()  // Asegúrate de que el ID se pasa a esta función
    {
        $this->alert('warning', 'Are you sure you want to revoke all permissions?', [
            'position' => 'center',
            'timer' => 8000,
            'toast' => false,  // Cambiado a false para que la alerta no desaparezca automáticamente
            'showConfirmButton' => true,
            'onConfirmed' => 'revokeall',  // Agregado un manejador para la confirmación
            'showCancelButton' => true,
            'onDismissed' => '',
            'showDenyButton' => false,
            'onDenied' => '',
            'timerProgressBar' => false,
            'width' => '600',
        ]);
    }
}
