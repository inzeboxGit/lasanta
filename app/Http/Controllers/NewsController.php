<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\PageHeaderSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class NewsController extends Controller
{
    public function index()
    {
        $items = News::where('status', 'published')
            ->with('translations')
            ->orderByDesc('published_at')
            ->paginate(9);

        $newsPageSetting = (object) [
            'header_image' => 'img/hero_home_2.jpg',
            'subtitle' => 'Expérience hôtelière',
            'title' => 'Actualités et événements',
            'hero_text' => 'Découvrez les nouvelles, événements et temps forts de la résidence.',
        ];

        if (Schema::hasTable('page_header_settings')) {
            $newsPageSetting = PageHeaderSetting::firstOrCreate(
                ['page' => 'news'],
                [
                    'header_image' => 'img/hero_home_2.jpg',
                    'subtitle' => 'Expérience hôtelière',
                    'title' => 'Actualités et événements',
                    'hero_text' => 'Découvrez les nouvelles, événements et temps forts de la résidence.',
                ]
            );
            $newsPageSetting->loadMissing('translations');
        }

        return view('news.index', compact('items', 'newsPageSetting'));
    }

    public function show(News $news)
    {
        abort_unless($news->status === 'published', 404);
        $news->loadMissing('translations');

        return view('news.show', compact('news'));
    }
}
