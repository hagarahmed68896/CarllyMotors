<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarDealersModel extends Model
{
    use HasFactory;
    protected $table = 'carlistingdealers';
    protected $fillable = [
        'id', 
        'user_id',
        'is_dealer',
        'is_top_dealer',
        'company_img',
        'company_name',
        'company_address',
        'reviews',
        'workshop_brands',
    ];
}