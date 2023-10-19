<?php

namespace App\Livewire;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class EditCoin extends ModalComponent
{
    public function render()
    {
        return view('livewire.edit-coin');
    }
}
