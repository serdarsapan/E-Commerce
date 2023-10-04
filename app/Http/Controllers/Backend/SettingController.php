<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\Slider;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = SiteSetting::get();
        return view('backend.pages.setting.index',compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.setting.edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        SiteSetting::create([
            'name'=>$request->name,
            'data'=>$request->data,
            'type'=>$request->type,
        ]);
        return back()->withSuccess('Created Successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $setting = SiteSetting::where('id',$id)->first();
        return view('backend.pages.setting.edit',compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $setting = SiteSetting::where('id',$id)->first();
        SiteSetting::where('id',$id)->update([
           'name'=>$request->name,
           'data'=>$request->data,
           'type'=>$request->type
        ]);
        return back()->withSuccess('Created Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
