<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Reports extends Component
{

    public $currentImage, $searchengine, $pageTitle, $componentName, $type, $value;

    public function render()
    {
        return view(
            'livewire.reports.reports',
            [
                'users' => User::orderBy('name', 'asc')->get(),

            ]
        );
    }
}
