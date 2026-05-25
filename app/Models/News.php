<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory, HasContentTranslations;

    protected $fillable = [
        'title',
        'slug',
        'author',
        'category',
        'published_at',
        'hero_image',
        'cover_image',
        'show_cover_image_in_body',
        'excerpt',
        'body',
        'status',
    ];

    protected $casts = [
        'published_at' => 'date',
        'show_cover_image_in_body' => 'boolean',
    ];
}
