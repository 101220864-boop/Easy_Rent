<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'name',
        'description',
        'property_Type',
        'price',
        'media_upload',
        'location',
        
    ];
    public function rentalRequests()
{
    return $this->hasMany(RentalRequest::class);
}
   
}
