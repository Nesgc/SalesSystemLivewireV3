<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denomination extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'value', 'image'];

    public function getImageAttribute($image)
    {

        if ($image && file_exists('storage/' . $image))
            return $image;
        else
            return 'categories/noimage.png';
    }
}
