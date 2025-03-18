<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $table = 'colors';
    protected $guarded = [];

    public function cars(){
        return $this->hasMany(CarListingModel::class, 'car_color');
    }
    
}
