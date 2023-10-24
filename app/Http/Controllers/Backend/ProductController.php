<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::orderBy('id','desc')->get();
        return view ('backend.pages.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Products::get()->first();
        return view('backend.pages.product.edit', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = Str::slug($request->name);
            $upFile = 'img/products/';
            $imageUrl = imgUpload($image,$fileName,$upFile);
        }

        Products::create([
            'name'=>$request->name,
            'category_id'=>$request->category_id,
            'content'=>$request->content,
            'short_text'=>$request->short_text,
            'price'=>$request->price,
            'size'=>$request->size,
            'color'=>$request->color,
            'qty'=>$request->qty,
            'image'=>$imageUrl ?? $request->image,
            'status'=>$request->status,
        ]);
        return back()->withSuccess('Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Products::where('id', $id)->first();

        $categories = Category::get();
        return view('backend.pages.product.edit', compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Products::where('id',$id)->firstOrFail();

        if ($request->hasFile('image')) {
            fileDel($product->image);
            $image = $request->file('image');
            $fileName = Str::slug($request->name);
            $upFile = 'img/products/';
            $imageUrl = imgUpload($image,$fileName,$upFile);
        }

        Products::where('id',$id)->update([
            'image'=>$imageUrl ?? $product->image,
            'name'=>$request->name,
            'content'=>$request->content,
            'category_id'=>$request->category_id,
            'short_text'=>$request->short_text,
            'price'=>$request->price,
            'size'=>$request->size,
            'color'=>$request->color,
            'qty'=>$request->qty,
            'status'=>$request->status,
        ]);
        return back()->withSuccess('Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $product = Products::where('id',$request->id)->firstOrFail();

        fileDel($product->image);
        $product->delete();
        return response(['error'=>false,'message'=>'Deleted Successfully!']);
    }

    public function status(Request $request)
    {
        $update = $request->statu;
        $updateCheck = $update == "false" ? '0' : '1';

        Products::where('id',$request->id)->update(['status'=> $updateCheck]);
        return response(['error'=>false,'status'=>$update]);
    }
}
