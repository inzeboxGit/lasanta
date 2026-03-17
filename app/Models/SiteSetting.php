<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory, HasContentTranslations;

    protected $fillable = [
        'setting_key',
        'site_name',
        'address',
        'email',
        'phone_primary',
        'phone_secondary',
        'facebook_url',
        'instagram_url',
        'whatsapp_url',
        'twitter_url',
    ];
}
