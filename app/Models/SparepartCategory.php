<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SparepartCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getCreatedAtAttribute($val)
    {
        return Carbon::parse($val)->format('d M, Y H:i');
    }
    
    public function getImageAttribute($val) {
        return ($val)?asset($val):asset('icon/sparepart.jpg');
    }

    public function spareParts() {
        return $this->hasMany(SparePart::class,'category_id');
    }
        /**
     * ✅ Relationship: One category can have many subcategories
     */
    public function subcategories()
    {
        return $this->hasMany(SparepartCategory::class, 'parent_id');
    }
}
