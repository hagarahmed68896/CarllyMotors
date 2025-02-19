<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Carbon\Carbon;

class WorkshopProvider extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $guarded=[];


    protected $hidden=[
        "password",
    ];


    public function getWorkshopLogoAttribute($val)
    {
        return asset($val);
    }

   
 
}
