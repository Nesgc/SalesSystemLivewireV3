<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use App\Models\Post;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class ImageUpload extends Component
{
    use WithFileUploads;
    use WithPagination;

    #[Rule('image|max:2048')] // 2MB Max
    public $image;

    #[Rule('required|min:3')]
    public $title;

    public $isOpen = 0;

    public function create()
    {
        $this->openModal();
    }

    public function store()
    {
        $this->validate();

        // get the filename with extension
        $fileNameWithExt = $this->image->getClientOriginalName();

        // get just the filename
        $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

        // get the file extension
        $extension = $this->image->getClientOriginalExtension();

        // filename to store
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;

        // Upload the image
        $path = $this->image->storeAs('public/photos', $fileNameToStore);

        Post::create([
            'title' => $this->title,
            'image' => $fileNameToStore,
        ]);

        session()->flash('success', 'Image uploaded successfully.');
        $this->reset('title', 'image');
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
    public function render()
    {
        return view('livewire.image-upload', [
            'posts' => Post::paginate(5),
        ]);
    }
}
