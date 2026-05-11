<?php

namespace App\Models;

use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeHeroSetting extends Model
{
    use HasFactory, HasContentTranslations;

    protected $fillable = [
        'section',
        'show_booking_form',
        'small_title',
        'title',
        'dates_label',
        'check_in_label',
        'check_out_label',
        'adults_label',
        'children_label',
        'rooms_label',
        'search_label',
        'button_text',
        'button_link',
        'button_target',
        'background_type',
        'background_video',
        'youtube_video_url',
        'background_image',
    ];

    protected $casts = [
        'show_booking_form' => 'boolean',
    ];
}
