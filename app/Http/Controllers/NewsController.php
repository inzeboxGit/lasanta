<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $items = News::where('status', 'published')
            ->with('translations')
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('news.index', compact('items'));
    }

    public function show(News $news)
    {
        abort_unless($news->status === 'published', 404);
        $news->loadMissing('translations');

        return view('news.show', compact('news'));
    }
}
