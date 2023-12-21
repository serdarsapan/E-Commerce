<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSeo extends Model
{
    use HasFactory;

    protected $table ="page_seos";
    protected $fillable = ['page','lang','page_top','title','description','keywords','contents'];

    public function images()
    {
        return $this->hasOne(ImageMedia::class,'table_id','id')->where('model_name','pageSeo');
    }
    public function pageinfo()
    {
        return $this->hasOne(PageSeo::class,'id','page_top');
    }

    public function pages()
    {
        return $this->hasMany(PageSeo::class,'page_top','id');
    }
}
