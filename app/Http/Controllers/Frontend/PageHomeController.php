<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use App\Models\Slider;

class PageHomeController extends Controller
{
    public function homePage()
    {
        $slider = Slider::where('status','1')->first();

        $lastProducts = Products::where('status','1')
            ->select(['id','name','slug','size','color','price','category_id','category_name','image'])
            ->orderBy('id','desc')
            ->limit(10)
            ->get();

        return view('frontend.pages.index', compact('slider','lastProducts'));
    }
}
