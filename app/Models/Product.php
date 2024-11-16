<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Mass assignment protection
    protected $guarded = [];

    // Define the relationship between Product and Category
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products'); // Define the pivot table here
    }

    // Define the relationship between Product and Feature
    public function feature()
    {
        return $this->hasMany(Feature::class);
    }
}

