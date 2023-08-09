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

        $categoryId = '';
        $category = $request->get('category');
        if ($category) {
            $categoryId = Category::whereSlug($category)->value('id');
        }

        $products = Products::query()
            ->where('status','1')
            ->when($size, function($query,$size) {
                return $query->where('size',$size);
            })
            ->when($color, function($query,$color) {
                return $query->where('color',$color);
            })->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->when($startPrice && $endPrice, function ($query) use ($startPrice,$endPrice) {
                return $query->whereBetween('price', [$startPrice, $endPrice]);
            })
            ->with('item:id,name,slug')
            ->whereHas('item',function ($query) use($item, $slug) {
                if (!empty($slug)) {
                    $query->where('slug', $slug);
                }
            })
            ->orderBy($order, $sort)
            ->paginate(21);


            $minPrice = $products->min('price');
            $maxPrice = $products->max('price');

            $sizeLists = Products::where('status','1')->groupBy('size')->pluck('size')->toArray();

            $colors = Products::where('status','1')->groupBy('color')->pluck('color')->toArray();

    return view('frontend.pages.products', compact('products','minPrice','maxPrice','sizeLists','colors'));
    }

    public function proDetail($slug)
    {
    $product = Products::where('slug', $slug)->where('status','1')->firstOrFail();
    $featureProducts = $this->featureProducts($product,5);

    return view('frontend.pages.proDetail', compact('product','featureProducts'));
    }
    public function featureProducts($product,$limit)
    {
        return Products::where('id','!=',$product->id)
            ->where('category_id',$product->category_id)
            ->where('status', '1')
            ->limit($limit)
            ->get();
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
