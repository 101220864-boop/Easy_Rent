<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\RequestController;
use App\Models\House;
use App\Models\RentalRequest;

Route::get('/', function(){
    $houses = House::all();
    return view('welcome',compact('houses'));
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'houses' => House::all(),
        'rentalRequests' => RentalRequest::with(['user', 'house'])->get()
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/houses',[HouseController::class,'index'])->name('houses.index');
    Route::get('/houses/create',[HouseController::class,'create'])->name('houses.create');
    Route::post('/houses',[HouseController::class,'store'])->name('houses.store');
    Route::post('/rental-requests',[RequestController::class,'store'])->name('rental.requests.store');
    Route::post('/rental-requests/{id}/approve',[RequestController::class,'approve'])->name('rental.requests.approve');
    Route::post('/rental-requests/{id}/reject',[RequestController::class,'reject'])->name('rental.requests.reject');
    Route::delete('/houses/{id}', [HouseController::class, 'destroy'])->name('houses.destroy');
});


require __DIR__.'/auth.php';
