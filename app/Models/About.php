<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'title',
        'content',
    ];

    public function images()
    {
        return $this->hasOne(ImageMedia::class,'table_id','id')->where('model_name','About');
    }
}
