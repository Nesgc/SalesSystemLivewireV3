<?php

namespace App\Livewire;

use App\Models\Denomination;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class Coins extends Component
{

    use WithFileUploads;
    use WithPagination;


    public $currentImage, $searchengine, $pageTitle, $componentName;
    #[Rule('nullable|image|max:3024')] // 1MB Max
    public $image;
    public $isEditMode = false;
    public $path;

    #[Rule('required')]
    public $selected_id;

    #[Rule('required|min:3|unique:categories,name,{$this->selected_id}')]
    public $name;

    public function mount()
    {
        $this->pageTitle = 'Listing';
        $this->componentName = 'Categories';
    }

    public function render()
    {


        $denominations = $this->searchengine
            ? Denomination::where('name', 'like', '%' . $this->searchengine . '%')->paginate(10)
            : Denomination::paginate(4);

        return view('livewire.coins', compact('denominations'));
    }
}
