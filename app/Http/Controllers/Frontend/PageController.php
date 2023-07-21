<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function products(Request $request)
    {


        $size = $request->size ?? null;
        $color = $request->color ?? null;
        $startPrice = $request->start_price ?? null;
        $endPrice = $request->end_price ?? null;


    $products = Products::where('status','1')->select(['id','name','slug','size','color','price','category_id','thumbnail'])
        ->where(function($query) use($size,$color,$startPrice,$endPrice) {
            if (!empty($size)) {
                $query->where('size',$size);
            }
            if (!empty($color)) {
                $query->where('color',$color);
            }
            if (!empty($startPrice && $endPrice)) {
                $query->whereBetween('price',[$startPrice,$endPrice]);
            }

            return $query;
        })
        ->with('item:id,name,slug');

            $minPrice = $products->min('price');
            $maxPrice = $products->max('price');

            $sizeLists = Products::where('status','1')->groupBy('size')->pluck('size')->toArray();

            $colors = Products::where('status','1')->groupBy('color')->pluck('color')->toArray();

        $products = $products->paginate(1);

        $categories = Category::where('status','1')->where('cat_ust', null)->withCount('items')->get();
    return view('frontend.pages.products', compact('products','categories','minPrice','maxPrice','sizeLists','colors'));
    }

    public function proDetail($slug)
    {
    $products = Products::where('slug', $slug)->first();
    return view('frontend.pages.proDetail', compact('products'));
    }
    public function aboutUs()
    {
        $marketing = About::where('title','marketing')->first();
        $sales = About::where('title', 'sales manager')->first();
        return view('frontend.pages.aboutUs', compact('marketing','sales'));
    }
    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function cart()
    {
        return view('frontend.pages.cart');
    }
    public function checkout()
    {
        return view('frontend.pages.checkout');
    }
    public function thankYou()
    {
        return view('frontend.pages.thankYou');
    }
}
