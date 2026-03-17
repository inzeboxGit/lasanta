<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Model;

class LocalAmenity extends Model
{
    use HasFactory, HasContentTranslations;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'link_url',
        'sort_order',
        'is_published',
    ];
}
