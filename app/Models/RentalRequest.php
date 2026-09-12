<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalRequest extends Model
{
   protected $fillable = [
    'user_id',
    'house_id',
    'status'
];
public function user()
{
    return $this->belongsTo(User::class);
}

public function house()
{
    return $this->belongsTo(House::class);
}

}
