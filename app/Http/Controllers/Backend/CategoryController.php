<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('subCategory:id,parent,name')->get();
        return view ('backend.pages.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('parent',null)->get();
        return view('backend.pages.category.edit', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = Str::slug($request->name);
            $upFile = 'img/category/';
            $imageUrl = imgUpload($image,$fileName,$upFile);
        }

        Category::create([
            'image'=>$imageUrl,
            'name'=>$request->name,
            'content'=>$request->content,
            'parent'=>$request->parent,
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
        $category = Category::where('id', $id)->first();
        return view('backend.pages.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::where('id',$id)->firstOrFail();

        if ($request->hasFile('image')) {
            fileDel($category->image);
            $image = $request->file('image');
            $fileName = '-'.Str::slug($request->name);
            $upFile = 'img/category/';
            $imageUrl = imgUpload($image,$fileName,$upFile);
        }

        Category::where('id',$id)->update([
            'name'=>$request->name,
            'content'=>$request->content,
            'parent'=>$request->parent,
            'status'=>$request->status,
            'image'=>$imageUrl ?? $category->image,
        ]);
        return back()->withSuccess('Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $category = Category::where('id',$request->id)->firstOrFail();

        fileDel($category->image);
        $category->delete();
        return response(['error'=>false,'message'=>'Deleted Successfully!']);
    }

    public function status(Request $request)
    {
        $update = $request->statu;
        $updateCheck = $update == "false" ? '0' : '1';

        Category::where('id',$request->id)->update(['status'=> $updateCheck]);
        return response(['error'=>false,'status'=>$update]);
    }
}
