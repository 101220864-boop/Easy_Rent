<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\House;

class HouseController extends Controller
{
    public function index(){
        $houses=House::all();
        return view('houses.index',compact('houses'));
    }
    public function create(){
        return view('houses.create');
    }
    public function store(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'location'=>'required|string|max:255',
            'price'=>'required|numeric',
            'property_Type'=>'required|string',
            'description'=>'required|string',
            'media_upload'=>'nullable|file|mimes:jpg,jpeg,png,mp4|max:20480',
        ]);
        $mediaPath=null;
        if($request->hasFile('media_upload')){
            $mediaPath=$request->file('media_upload')->store('house_media','public');
        }
        House::create([
            'user_id'=>auth()->id(),
            'name'=>$request->name,
            'location'=>$request->location,
            'price'=>$request->price,
            'property_Type' => $request->property_Type,
            'description' => $request->description,
            'media_upload' => $mediaPath,
        ]);
        return redirect()->route('houses.index')->with('success','House added successfully!');
    }
        public function destroy($id)
            {
            
                $house = House::findOrFail($id);
                
                $house->delete();

                return redirect()->route('houses.index')->with('success', 'House deleted successfully!');
            }
}
