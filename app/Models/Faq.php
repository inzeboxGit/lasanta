<?php

namespace App\Models;

use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasContentTranslations;

    protected $fillable = [
        'question',
        'answer',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order'   => 'integer',
    ];
}
