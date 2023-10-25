<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use App\Livewire\Roles;
use App\Models\Sale;
use Spatie\Permission\Models\Role;

class Users extends Component
{

    use WithPagination;
    use LivewireAlert;
    use WithFileUploads;

    public $tempImage;
    public $name, $phone, $email, $status, $image, $password, $selected_id, $fileLoaded, $role, $profile;
    public  $componentName, $pageTitle, $roleName, $searchengine, $guard_name, $rolesList, $currentImage;
    private $pagination = 5;
    public function mount()
    {
        $this->pageTitle = 'Listing';
        $this->componentName = 'Users';
        $this->status = 'Elegir';
    }
    public function render()
    {

        if (strlen($this->searchengine) > 0)
            $users = User::where('name', 'like', '%' . $this->searchengine . '%')
                ->select('*')->orderBy('name', 'asc')->paginate($this->pagination);
        else
            $users = User::select('*')->orderBy('name', 'asc')->paginate($this->pagination);



        return view('livewire.users.users', [
            'roles' => Role::orderBy('name', 'asc')->get(),
            'users' => $users
        ]);
    }

    public function create()
    {
        $this->reset('name', 'image', 'phone', 'email', 'profile', 'status', 'password');

        $this->resetUI();
    }

    public function Store()
    {

        // Validar si la imagen no es obligatoria o hacer validaciones personalizadas
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|unique:users|email',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3'

        ]);

        // Verificar si la imagen está presente
        $imagePath = $this->image
            ? $this->image->store('users')
            : 'null';  // puedes ajustar esto según tus necesidades

        User::create([
            'name' => $this->name,
            'image' => $imagePath,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => $this->profile,
            'password' => bcrypt($this->password),
        ]);


        $this->resetUI();
        $this->alert('success', 'Created Succesfully');

        $this->dispatch('user-added', 'Usuario Registrado');
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

        $user = User::find($this->selected_id);
        if ($user) {
            $sales = Sale::where('user_id', $user->id)->count();
            if ($sales > 0) {
                $this->alert('warning', 'User cant be deleted because it has registered sales.');
            } else {

                $user->delete();
                $this->resetUI();

                $this->alert('success', 'The user has been deleted.');
            }
        }
    }

    protected $listeners = [
        'confirmedDeletion',
        'resetUI'
    ];

    public function resetUI()
    {

        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->phone = '';
        $this->image = '';
        $this->searchengine = '';
        $this->status = 'Elegir';
        $this->selected_id = 0;
        $this->resetValidation();
    }

    public function edit(User $user)
    {
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = $user->password;
        $this->phone = $user->phone;
        $this->image = $user->image;  // Ruta de la imagen existente
        $this->tempImage = null;  // Resetear la imagen temporal
        $this->status = $user->status;
        $this->profile = $user->profile;
        $this->dispatch('show-modal', 'Show modal');
    }

    public function Update()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $this->selected_id,
            'phone' => 'required|min:3',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3'

        ]);

        if ($this->selected_id) {
            $user = User::find($this->selected_id);


            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'status' => $this->status,
                'profile' => $this->profile,
                'password' => bcrypt($this->password),

            ];

            if ($this->tempImage) {
                $data['image'] = $this->tempImage->store('users');
            }

            $user->update($data);
            $this->alert('success', 'Updated Succesfully');

            $this->resetUI();
            $this->dispatch('user-updated', 'user Actualizado');
        }
    }
}
