<?php

namespace App\Models;

use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoSectionSetting extends Model
{
    use HasFactory, HasContentTranslations;

    protected $fillable = [
        'section',
        'is_enabled',
        'start_date',
        'end_date',
        'subtitle',
        'title',
        'text',
        'button_link',
        'button_text',
        'image',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
