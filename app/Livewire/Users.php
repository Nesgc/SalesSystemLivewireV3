<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class Users extends Component
{

    public  $componentName, $pageTitle, $roleName, $selected_id, $searchengine, $guard_name, $rolesList, $image;
    private $pagination = 5;
    public function mount()
    {
        $this->pageTitle = 'Listing';
        $this->componentName = 'Users';
    }
    public function render()
    {

        $users = $this->searchengine
            ? User::where('name', 'like', '%' . $this->searchengine . '%')
            ->orWhere('email', 'like', '%' . $this->searchengine . '%')->paginate(10)
            : User::paginate(10);

        return view('livewire.users.users', compact('users'));
    }
}
