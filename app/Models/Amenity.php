<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Model;
use App\Models\Room;

class Amenity extends Model
{
    use HasFactory, HasContentTranslations;

    protected $fillable = [
        'title',
        'icon',
        'description',
        'image_path',
        'scope',
        'sort_order',
        'is_published',
    ];

    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }
}
