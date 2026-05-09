<?php

namespace App\Models;

use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Model;

class FaqSectionSetting extends Model
{
    use HasContentTranslations;

    protected $fillable = [
        'subtitle',
        'title',
        'description',
        'button_label',
        'button_link',
    ];
}
