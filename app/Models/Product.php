<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'barcode', 'cost', 'price', 'stock', 'alerts', 'image', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function getImageAttribute($image)
    {

        if (file_exists('storage/' . $image))
            return $image;
        else
            return 'categories/noimage.png';
    }
}
