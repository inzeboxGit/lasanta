<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Model;

class AboutSectionSetting extends Model
{
    use HasFactory, HasContentTranslations;

    protected $fillable = [
        'section',
        'small_title',
        'title',
        'lead',
        'description',
        'signature',
        'main_image',
        'overlay_image',
    ];
}
