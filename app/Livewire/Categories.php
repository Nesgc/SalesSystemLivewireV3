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

    public $name, $searchengine, $selected_id, $pageTitle, $componentName;
    #[Rule('image|max:1024')] // 1MB Max
    public $image;
    public $isOpen = 0;
    public $path;

    public function mount()
    {
        $this->pageTitle = 'Listing';
        $this->componentName = 'Categories';
    }
    public function render()
    {

        if ($this->searchengine == "") {
            $categories = Category::paginate(4);
        } else {
            $categories = Category::where('name', 'like', '%' . $this->searchengine . '%')->paginate(50);
        }



        return view('livewire.categories', compact('categories'));
    }

    public function Edit($id)
    {
        $record = Category::find($id, ['id', 'name', 'image']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->dispatch('show-modal', 'show modal!');
    }

    public function Store()
    {
        $this->validate();
        Category::create([
            'name' => $this->name,
            'image' => $this->image->store('public/photos')
        ]);
        session()->flash('success', 'Image uploaded successfully.');
        $this->reset('name', 'image');
        $this->closeModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
        $this->resetValidation();
    }
    public function closeModal()
    {
        $this->isOpen = false;
    }
    public function resetUI()
    {
        $this->name = '';
        $this->image = null;
        $this->searchengine = '';
        $this->selected_id = 0;
    }
}
