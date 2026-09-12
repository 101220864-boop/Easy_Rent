<?php

namespace App\Http\Controllers;
use App\Models\RentalRequest;
use App\Models\House;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'house_id'=>'required|exists:houses,id',
        ]);
        RentalRequest::create([
        'user_id'=>auth()->id(),
        'house_id'=>$request->house_id,
        'status'=>'pending',
        ]);
        return redirect()->back()->with('success','Rental request is sent successfully!');
    }
    public function approve($id)
{
    
    $request = RentalRequest::findOrFail($id);
    $request->status = 'accepted';
    $request->save();

    
    $house = House::findOrFail($request->house_id); 
    $house->status = 'rented';
    $house->save();

    return redirect()->back()->with('success', 'Request approved and house is now Rented!');
}
    public function reject($id){
        $rentalRequest=RentalRequest::findOrFail($id);
        $rentalRequest->update(['status'=>'rejected']);
        return redirect()->back()->with('success','Request rejected!');
    }
}
