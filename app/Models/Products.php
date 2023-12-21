<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use Sluggable,HasFactory;



    protected $fillable = [
        'name',
        'slug',
        'image',
        'thumbnail',
        'category_id',
        'category_name',
        'short_text',
        'price',
        'size',
        'color',
        'qty',
        'status',
        'content',
    ];
    public function images()
    {
        return $this->hasOne(ImageMedia::class,'table_id','id')->where('model_name','Products');
    }

    public function item()
    {
        return $this->hasOne(Category::class,'id','category_id');
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
