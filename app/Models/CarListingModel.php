<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CarListingModel extends Model
{
    use HasFactory;
    protected $table = 'carlisting';
    protected $appends = ['img1','img2','img3','img4','img5'];
    protected $guarded=[];

    public function getImg1Attribute() {
        return asset($this->listing_img1);
    }
    public function getImg2Attribute() {
        return asset($this->listing_img2);
    }
    public function getImg3Attribute() {
        return asset($this->listing_img3);
    }
    public function getImg4Attribute() {
        return asset($this->listing_img4);
    }
    public function getImg5Attribute() {
        return asset($this->listing_img5);
    }

    public function user() {
        return $this->belongsTo(allUsersModel::class,'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(allUsersModel::class, 'carlisting_allusers', 'carlisting_id', 'user_id')
                    ->withTimestamps(); // Keeps track of created_at & updated_at
    }


    public function color(){
        return $this->belongsTo(Color::class, 'car_color', 'uid');
    }

    public function images(){
        return $this->hasMany(Image::class,'carlisting_id');
    }

    // public function getCreatedAtAttribute($val)
    // {
    //     return Carbon::parse($val)->format('d M, Y H:i');
    // }
}