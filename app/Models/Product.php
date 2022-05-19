<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['preview'];

    //Relation To Categoty
    function rel_to_category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    //Relation To Subcategory
    function rel_to_subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    //Relation To Thumbnail
    function rel_to_product_thumbnail()
    {
        return $this->hasMany(ProductThumbnail::class, 'product_id');
    }
}
