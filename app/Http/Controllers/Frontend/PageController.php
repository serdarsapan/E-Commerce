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
        $sizes = !empty($request->size) ? explode(',',$request->size) : null;
        $colors = !empty($request->color) ? explode(',',$request->color) : null;
        $startPrice = $request->min ?? null;
        $endPrice = $request->max ?? null;
        $order = $request->order ?? 'id';
        $sort = $request->sort ?? 'desc';

        $categoryId = '';
        $category = $request->get('category');
        if ($category) {
            $categoryId = Category::whereSlug($category)->value('id');
        }

        $products = Products::query()
            ->where('status','1')
            ->when($sizes, function($query,$sizes) {
                return $query->whereIn('size',$sizes);
            })
            ->when($colors, function($query,$colors) {
                return $query->whereIn('color',$colors);
            })
            ->when($categoryId, function ($query, $categoryId) {
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

            if($request->ajax()) {
                $view = view('frontend.ajax.productList', compact('products'))->render();
                return response(['data'=>$view, 'paginate'=>(string) $products->withQueryString()->links('pagination::bootstrap-4')]);
            }

            $sizeLists = Products::where('status','1')->groupBy('size')->pluck('size')->toArray();

            $colors = Products::where('status','1')->groupBy('color')->pluck('color')->toArray();

            $maxPrice = Products::max('price');

    return view('frontend.pages.products', compact('products','maxPrice','endPrice','sizeLists','colors'));
    }

    public function proDetail($slug)
    {
    $product = Products::where('slug', $slug)->where('status','1')->firstOrFail();
    $featureProducts = $this->featureProducts($product,5);
        $lastProducts = Products::where('status','1')
            ->select(['id','name','slug','size','color','price','category_id','category_name','image'])
            ->orderBy('id','desc')
            ->limit(10)
            ->get();
    return view('frontend.pages.proDetail', compact('product','featureProducts','lastProducts'));
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
    public function thankYou()
    {
        return view('frontend.pages.thankYou');
    }
}
