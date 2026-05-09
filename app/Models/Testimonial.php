<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory, HasContentTranslations;

    protected $fillable = [
        'name',
        'content',
        'source',
        'photo_path',
        'published_at',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_published' => 'boolean',
    ];
}
