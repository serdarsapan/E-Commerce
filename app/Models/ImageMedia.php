<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageMedia extends Model
{
    use HasFactory;

    protected $fillable = ['table_id', 'model_name','data'];

    public function images()
    {
        return $this->hasOne(ImageMedia::class,'table_id','id')->where('model_name','pageSeo');
    }
}
