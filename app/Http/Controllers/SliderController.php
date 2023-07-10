<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;
class SliderController extends Controller
{
    public function addslider(){
        return view('admin.addslider');
    }
    public function sliders(){
        $sliders=Slider::All();
        return view('admin.sliders')->with('sliders',$sliders);
    }
    public function saveslider(Request $request){
        $this->validate($request,['description1'=> 'required',
                                    'description2'=>'required',
                                    'slider_image'=>'image|nullable|max:1999|required']);
        
        
        $fileNameWithExt=$request->file('slider_image')->getClientOriginalName();
        $fileName=pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $extension=$request->file('slider_image')->getClientOriginalExtension();
        $fileNameToStore=$fileName.'_'.time().'.'.$extension;
        $path=$request->file('slider_image')->storeAs('public/sliders_images',$fileNameToStore);
        
        $slider=new Slider();
        $slider->description1=$request->input('description1');
        $slider->description2=$request->input('description2');
        $slider->slider_image=$fileNameToStore;
        $slider->status=1;
        $slider->save();

        return back()->with('status','Saved successfully');
    }
    public function editslider($id){
        $slider=Slider::find($id);
        return view('admin.editslider')->with('slider',$slider);
    }
    public function updateslider(Request $request){
        $this->validate($request,['description1'=> 'required',
                                  'description2'=>'required',
                                  'slider_image'=>'image|nullable|max:1999']);
        $slider=Slider::find($request->input('id'));
        $slider->description1=$request->input('description1');
        $slider->description2=$request->input('description2');

        if($request->hasFile('slider_image')){
            $fileNameWithExt=$request->file('slider_image')->getClientOriginalName();
            $fileName=pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension=$request->file('slider_image')->getClientOriginalExtension();
            $fileNameToStore=$fileName.'_'.time().'.'.$extension;
            $path=$request->file('slider_image')->storeAs('public/sliders_images',$fileNameToStore);
            Storage::delete('public/sliders_images/'.$slider->slider_image);
            
            $slider->slider_image=$fileNameToStore;
        }
        $slider->update();

        return redirect('/sliders')->with('status','Updated successfully');
    }
    public function deleteslider($id){
        $slider=Slider::find($id);
        Storage::delete('public/sliders_images/'.$slider->slider_image);
        $slider->delete();
        return back()->with('status','Deleted successfully');
    }
    public function activateslider($id){
        $slider=Slider::find($id);
        $slider->status=1;
        $slider->update();
        return back()->with('status','Activated successfully');
    }
    public function unactivateslider($id){
        $slider=Slider::find($id);
        $slider->status=0;
        $slider->update();
        return back()->with('status','Unctivated  successfully');
    }
}
