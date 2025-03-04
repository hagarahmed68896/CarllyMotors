<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class allUsersModel extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    protected $table = 'allusers';
    protected $guarded = [];
    protected $hidden = ['password'];
    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function getImageAttribute($val) {
        return asset($val);
    }

    public function dealer() {
        return $this->hasOne(CarDealer::class,'user_id');
    }

    public function spareParts() {
        return $this->hasMany(SparePart::class,'user_id');
    }

    public function cars() {
        return $this->hasMany(carListingModel::class,'user_id');
    }

    public function favCars() {
        return $this->belongsToMany(CarListingModel::class, 'carlisting_allusers', 'user_id', 'carlisting_id')
                    ->withTimestamps();
    }

    public function getCreatedAtAttribute($val)
    {
        return Carbon::parse($val)->format('d M, Y H:i');
    }
}
