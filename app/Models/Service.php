<?php

namespace App\Models;

use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory, HasContentTranslations;

    protected $fillable = [
        'tab_key',
        'subtitle',
        'title',
        'description',
        'image',
        'button_link',
        'button_text',
        'icon',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order'   => 'integer',
    ];
}
