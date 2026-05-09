<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Model;
use App\Models\Amenity;

class Room extends Model
{
    use HasFactory, HasContentTranslations;

    protected $fillable = [
        'title',
        'subtitle',
        'external_id',
        'slug',
        'price_per_night',
        'discount',
        'description',
        'checkin_info',
        'checkout_info',
        'special_instructions',
        'children_policy',
        'main_image',
        'gallery',
        'status',
    ];

    protected $casts = [
        'gallery' => 'array',
    ];

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class);
    }
}
