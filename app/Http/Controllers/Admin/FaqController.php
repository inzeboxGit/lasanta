<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqSectionSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $faqs = collect();
        $faqSectionSetting = null;
        $editingFaq = null;

        if (Schema::hasTable('faqs')) {
            $faqs = Faq::orderBy('sort_order')->orderBy('id')->get();
            $editingFaq = $request->filled('edit')
                ? Faq::find($request->integer('edit'))
                : null;
        }

        if (Schema::hasTable('faq_section_settings')) {
            $faqSectionSetting = FaqSectionSetting::firstOrCreate(
                ['id' => 1],
                [
                    'subtitle'     => 'Questions populaires',
                    'title'        => 'Foire aux questions',
                    'description'  => '',
                    'button_label' => 'Toutes les questions',
                    'button_link'  => '#',
                ]
            );
            $faqSectionSetting->loadMissing('translations');
        }

        return view('admin.faqs.index', compact('faqs', 'faqSectionSetting', 'editingFaq'));
    }

    public function store(Request $request)
    {
        $data = $this->validateFaq($request);
        $data['is_published'] = $request->boolean('is_published');
        Faq::create($data);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ créée.');
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $this->validateFaq($request, $faq->id);
        $data['is_published'] = $request->boolean('is_published');
        $faq->update($data);

        return redirect()->route('admin.faqs.index', ['edit' => $faq->id])->with('success', 'FAQ mise à jour.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ supprimée.');
    }

    public function updateSectionSettings(Request $request)
    {
        $data = $request->validate([
            'subtitle'     => ['nullable', 'string', 'max:255'],
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'button_label' => ['nullable', 'string', 'max:255'],
            'button_link'  => ['nullable', 'string', 'max:2048'],
        ]);

        $setting = FaqSectionSetting::firstOrCreate(['id' => 1]);
        $setting->update($data);

        return redirect()->route('admin.faqs.index')->with('success', 'Paramètres de la section FAQ mis à jour.');
    }

    private function validateFaq(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'question'   => ['required', 'string', 'max:500'],
            'answer'     => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
