<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";

    protected $fillable = [
        'name',
        'slug',
        'image',
        'status'
    ];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }
}
