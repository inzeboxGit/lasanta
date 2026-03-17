<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $types = config('content_translations.types', []);
        $locales = config('content_translations.locales', ['fr' => 'Français']);

        $selectedType = $request->query('type', array_key_first($types));
        if (!isset($types[$selectedType])) {
            $selectedType = array_key_first($types);
        }

        $typeConfig = $types[$selectedType] ?? null;
        $records = collect();
        $record = null;
        $selectedId = null;

        if ($typeConfig) {
            $modelClass = $typeConfig['class'];
            $records = $modelClass::query()->orderByDesc('id')->limit(200)->get();
            $selectedId = $request->query('id', $records->first()?->id);
            $record = $selectedId ? $modelClass::with('translations')->find($selectedId) : null;
        }

        $selectedLocale = $request->query('locale', 'en');
        if (!isset($locales[$selectedLocale])) {
            $selectedLocale = 'en';
        }

        return view('admin.translations.index', compact(
            'types',
            'typeConfig',
            'selectedType',
            'records',
            'record',
            'selectedId',
            'locales',
            'selectedLocale'
        ));
    }

    public function update(Request $request)
    {
        $types = config('content_translations.types', []);
        $locales = config('content_translations.locales', ['fr' => 'Français']);

        $validated = $request->validate([
            'type' => ['required', 'string'],
            'id' => ['required', 'integer'],
            'locale' => ['required', 'string'],
            'fields' => ['nullable', 'array'],
        ]);

        $typeKey = $validated['type'];
        if (!isset($types[$typeKey])) {
            return back()->withErrors(['type' => 'Type de contenu invalide.']);
        }

        if (!isset($locales[$validated['locale']])) {
            return back()->withErrors(['locale' => 'Langue invalide.']);
        }

        $typeConfig = $types[$typeKey];
        $modelClass = $typeConfig['class'];
        $fields = $typeConfig['fields'] ?? [];
        $record = $modelClass::findOrFail($validated['id']);

        $payload = $request->input('fields', []);
        $rules = [];
        foreach ($fields as $field) {
            $rules[$field] = ['nullable', 'string'];
        }

        $validator = Validator::make($payload, $rules);
        $validator->validate();

        $locale = $validated['locale'];

        foreach ($fields as $field) {
            $value = $payload[$field] ?? null;
            $record->setTranslation($field, $locale, $value);
        }

        return redirect()->route('admin.translations.index', [
            'type' => $typeKey,
            'id' => $record->id,
            'locale' => $locale,
        ])->with('success', 'Traductions enregistrées.');
    }
}
