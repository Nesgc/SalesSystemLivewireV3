<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;


class Categories extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $image, $searchengine, $selected_id, $pageTitle, $componentName;

    public function mount()
    {
        $this->pageTitle = 'Listing';
        $this->componentName = 'Categories';
    }
    public function render()
    {

        if ($this->searchengine == "") {
            $categories = Category::paginate(2);
        } else {
            $categories = Category::where('name', 'like', '%' . $this->searchengine . '%')->paginate(50);
        }



        return view('livewire.categories', compact('categories'));
    }
}
