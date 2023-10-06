<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Livewire\Categories;
use App\Models\Product;


class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function getImageAttribute($image)
    {

        if (file_exists('storage/' . $image))
            return $image;
        else
            return 'categories/noimage.png';
    }
}
