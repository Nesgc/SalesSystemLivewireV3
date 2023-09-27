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
        $rules = [
            'name' => 'required|unique:categories|min:3'
        ];
        $messages = [
            'name.required' => 'Nombre de la categoria es requerido',
            'name.unique' => 'Ya existe el nombre de la categoria',
            'name.min' => 'El nombre de la categoria debe tener almenos 3 caracteres'
        ];
        $this->validate($rules, $messages);
        $category = Category::create([
            'name' => $this->name
        ]);

        $this->image->store('categories');


        $this->resetUI();
        $this->dispatch('category-added', 'Categoria Registrada');
    }

    public function resetUI()
    {
        $this->name = '';
        $this->image = null;
        $this->searchengine = '';
        $this->selected_id = 0;
    }
}
