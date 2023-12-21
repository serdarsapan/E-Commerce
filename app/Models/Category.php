<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use Sluggable,HasFactory;

    protected $fillable = [
        'image',
        'thumbnail',
        'name',
        'slug',
        'content',
        'parent',
        'status',
    ];

    public function images()
    {
        return $this->hasOne(ImageMedia::class,'table_id','id')->where('model_name','Category');
    }

    public function items()
    {
        return $this->hasMany(Products::class,'category_id','id');
    }

    public function subCategory()
    {
        return $this->hasMany(Category::class, 'parent','id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
