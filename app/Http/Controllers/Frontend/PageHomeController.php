<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use App\Models\Slider;
use App\Models\PageSeo;

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


        $seoLists = metaCreate('');

        $seo = [
            'title' => $seoLists['title'] ?? '',
            'description' => $seoLists['description'] ?? '',
            'keywords' => $seoLists['keywords'] ?? '',
            'image' => asset('img/page-bg.jpg'),
            'url' => $seoLists['currenturl'],
            'canonical' => $seoLists['trpage'],
            'robots' => 'index, follow'
        ];

        return view('frontend.pages.index', compact('seo','slider','lastProducts'));
    }
}
