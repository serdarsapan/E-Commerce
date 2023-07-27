<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slider;

class PageHomeController extends Controller
{
    public function homePage()
    {
        $slider = Slider::where('status','1')->first();

        return view('frontend.pages.index', compact('slider'));
    }
}
