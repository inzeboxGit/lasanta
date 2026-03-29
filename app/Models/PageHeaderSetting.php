<?php

namespace App\Models;

use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageHeaderSetting extends Model
{
    use HasFactory, HasContentTranslations;

    protected $fillable = [
        'page',
        'header_image',
        'subtitle',
        'title',
        'hero_text',
        'availability_small',
        'availability_title',
        'availability_text',
        'map_latitude',
        'map_longitude',
    ];
}
