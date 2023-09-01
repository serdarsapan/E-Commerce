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
            $extension = $image->getClientOriginalExtension();
            $fileName = '-'.Str::slug($request->name);
            $upFile = 'img/slider';

            if ($extension == 'pdf' || $extension == 'svg' || $extension == 'webp' ) {

                $image->move(public_path($upFile),$fileName.'.'.$extension);

                $imageUrl = $upFile.$fileName.'.'.$extension;
            }else{
                $image = ImageResize::make($image);
                $image->encode('webp', 75)->save($upFile.$fileName.'.webp');

                $imageUrl = $upFile.$fileName.'.webp';
            }

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
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName = '-'.Str::slug($request->name);
            $upFile = 'img/slider';

            if ($extension == 'pdf' || $extension == 'svg' || $extension == 'webp' ) {

                $image->move(public_path($upFile),$fileName.'.'.$extension);

                $imageUrl = $upFile.$fileName.'.'.$extension;
            }else{
                $image = ImageResize::make($image);
                $image->encode('webp', 75)->save($upFile.$fileName.'.webp');

                $imageUrl = $upFile.$fileName.'.webp';
            }

        }

        Slider::where('id',$id)->update([
            'name'=>$request->name,
            'content'=>$request->content,
            'link'=>$request->link,
            'status'=>$request->status,
            'image'=>$imageUrl ?? null,
        ]);
        return back()->withSuccess('Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::where('id', $id)->firstOrFail();

        if (file_exists(!empty($slider->image))) {
                unlink($slider->image);
        }

        $slider->delete();
        return back()->withSuccess('Deleted Successfully!');
    }
}
