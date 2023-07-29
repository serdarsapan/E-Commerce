<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function products(Request $request,$slug=null)
    {
        $item = request()->segment(1) ?? null;
        $size = $request->size ?? null;
        $color = $request->color ?? null;
        $startPrice = $request->start_price ?? null;
        $endPrice = $request->end_price ?? null;
        $order = $request->order ?? 'id';
        $sort = $request->sort ?? 'desc';



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
        ->with('item:id,name,slug')
        ->whereHas('item',function($query) use($item,$slug) {
            if (!empty($slug)) {
                $query->where('slug', $slug);
            }
        });

            $minPrice = $products->min('price');
            $maxPrice = $products->max('price');

            $sizeLists = Products::where('status','1')->groupBy('size')->pluck('size')->toArray();

            $colors = Products::where('status','1')->groupBy('color')->pluck('color')->toArray();


        $products = $products->orderBy($order,$sort)->paginate(20);

    return view('frontend.pages.products', compact('products','minPrice','maxPrice','sizeLists','colors'));
    }

    public function proDetail($slug)
    {
    $products = Products::where('slug', $slug)->where('status','1')->firstOrFail();

        $product = Products::where('id','!=',$products->id)
            ->where('category_id',$products->category_id)
            ->where('status', '1')
            ->limit(5)
            ->get();
    return view('frontend.pages.proDetail', compact('products','product'));
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

    public function checkout()
    {
        return view('frontend.pages.checkout');
    }
    public function thankYou()
    {
        return view('frontend.pages.thankYou');
    }
}
