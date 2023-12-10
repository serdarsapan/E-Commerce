<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use ImageResize;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::get();
        return view ('backend.pages.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.slider.edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = Str::slug($request->name);
            $upFile = 'img/slider/';
            $imageUrl = imgUpload($image,$fileName,$upFile);
        }

        Slider::create([
            'image'=>$imageUrl,
            'name'=>$request->name,
            'content'=>$request->content,
            'link'=>$request->link,
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
        $slider = Slider::where('id', $id)->first();
        return view('backend.pages.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $slider = Slider::where('id',$id)->firstOrFail();

        if ($request->hasFile('image')) {
            fileDel($slider->image);
            $image = $request->file('image');
            $fileName = Str::slug($request->name);
            $upFile = 'img/slider/';
            $imageUrl = imgUpload($image,$fileName,$upFile);
        }

        Slider::where('id',$id)->update([
            'name'=>$request->name,
            'content'=>$request->content,
            'link'=>$request->link,
            'status'=>$request->status,
            'image'=>$imageUrl ?? $slider->image,
        ]);
        return back()->withSuccess('Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $slider = Slider::where('id',$request->id)->firstOrFail();

        fileDel($slider->image);
        $slider->delete();
        return response(['error'=>false,'message'=>'Deleted Successfully!']);
    }

    public function status(Request $request)
    {
        $update = $request->statu;
        $updateCheck = $update == "false" ? '0' : '1';

        Slider::where('id',$request->id)->update(['status'=> $updateCheck]);
        return response(['error'=>false,'status'=>$update]);
    }
}
