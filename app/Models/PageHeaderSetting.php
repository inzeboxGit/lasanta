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
        'info_booking_label',
        'select_room_label',
        'adults_label',
        'children_label',
        'book_now_label',
        'calendar_night_label',
        'calendar_nights_label',
        'map_latitude',
        'map_longitude',
    ];
}
