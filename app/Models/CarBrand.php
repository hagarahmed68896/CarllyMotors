<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getCreatedAtAttribute($val)
    {
        return Carbon::parse($val)->format('d M, Y H:i');
    }
    public function cars()
    {
        return $this->hasMany(CarListingModel::class, 'listing_type', 'name');
    }

    public function models()
    {
        return $this->hasMany(BrandModel::class, 'brand_id');
    }


}
