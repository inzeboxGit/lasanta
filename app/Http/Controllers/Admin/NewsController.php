<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\PageHeaderSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::latest()->paginate(10);
        $newsPageSetting = $this->resolvePageSetting();
        $newsSectionSetting = Schema::hasTable('page_header_settings')
            ? PageHeaderSetting::firstOrCreate(
                ['page' => 'home_news_section'],
                ['subtitle' => 'Dernières nouvelles', 'title' => 'Actualités', 'header_image' => '', 'hero_text' => '']
            )
            : (object) ['subtitle' => 'Dernières nouvelles', 'title' => 'Actualités'];

        return view('admin.news.index', compact('news', 'newsPageSetting', 'newsSectionSetting'));
    }

    public function updateHomeSectionSettings(Request $request)
    {
        if (! Schema::hasTable('page_header_settings')) {
            return redirect()->route('admin.news.index')->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $setting = PageHeaderSetting::firstOrCreate(
            ['page' => 'home_news_section'],
            ['subtitle' => 'Dernières nouvelles', 'title' => 'Actualités', 'header_image' => '', 'hero_text' => '']
        );

        $data = $request->validate([
            'subtitle' => ['nullable', 'string', 'max:255'],
            'title'    => ['nullable', 'string', 'max:255'],
        ]);

        $setting->update([
            'subtitle' => $data['subtitle'] ?? $setting->subtitle,
            'title'    => $data['title'] ?? $setting->title,
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Section Actualités (home) mise à jour.');
    }

    public function updatePageSettings(Request $request)
    {
        if (! Schema::hasTable('page_header_settings')) {
            return redirect()->route('admin.news.index')->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $setting = $this->resolvePageSetting();
        $data = $request->validate([
            'subtitle' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'hero_text' => ['nullable', 'string'],
            'header_image' => ['nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('header_image')) {
            if (! empty($setting->header_image) && ! str_starts_with($setting->header_image, 'img/')) {
                Storage::disk('public')->delete($setting->header_image);
            }

            $data['header_image'] = $request->file('header_image')->store('page-headers', 'public');
        }

        $setting->update([
            'subtitle' => $data['subtitle'] ?? $setting->subtitle,
            'title' => $data['title'] ?? $setting->title,
            'hero_text' => $data['hero_text'] ?? $setting->hero_text,
            'header_image' => $data['header_image'] ?? $setting->header_image,
        ]);

        return redirect()->route('admin.news.index')->with('success', 'En-tête de la page actualités mise à jour.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);

        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = $request->file('hero_image')->store('news', 'public');
        }
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('news', 'public');
        }

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'Actualité créée.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('admin.news.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = News::findOrFail($id);

        return view('admin.news.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = News::findOrFail($id);
        $data = $this->validatedData($request, $item->id);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);

        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = $request->file('hero_image')->store('news', 'public');
        }
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('news', 'public');
        }

        $item->update($data);

        return redirect()->route('admin.news.index')->with('success', 'Actualité mise à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = News::findOrFail($id);
        $item->delete();

        return redirect()->route('admin.news.index')->with('success', 'Actualité supprimée.');
    }

    private function validatedData(Request $request, ?int $ignoreId = null): array
    {
        $uniqueSlug = 'unique:news,slug';
        if ($ignoreId) {
            $uniqueSlug .= ',' . $ignoreId;
        }

        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', $uniqueSlug],
            'author' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'published_at' => ['nullable', 'date'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'hero_image' => ['nullable', 'image', 'max:5120'],
            'cover_image' => ['nullable', 'image', 'max:5120'],
            'status' => ['required', 'in:draft,published'],
        ]);
    }

    private function resolvePageSetting(): object
    {
        $defaults = [
            'page' => 'news',
            'subtitle' => 'Expérience hôtelière',
            'title' => 'Actualités et événements',
            'hero_text' => 'Découvrez les nouvelles, événements et temps forts de la résidence.',
            'header_image' => 'img/hero_home_2.jpg',
        ];

        if (! Schema::hasTable('page_header_settings')) {
            return (object) $defaults;
        }

        return PageHeaderSetting::firstOrCreate(
            ['page' => 'news'],
            $defaults
        );
    }
}
