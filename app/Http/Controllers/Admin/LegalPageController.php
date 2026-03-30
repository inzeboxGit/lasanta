<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegalPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class LegalPageController extends Controller
{
    public function index()
    {
        if (!Schema::hasTable('legal_pages')) {
            abort(500, 'La table legal_pages est introuvable.');
        }

        [$privacyPage, $termsPage] = $this->loadPages();

        return view('admin.legal.index', compact('privacyPage', 'termsPage'));
    }

    public function update(Request $request)
    {
        if (!Schema::hasTable('legal_pages')) {
            return redirect()->route('admin.legal.index')->withErrors([
                'legal' => 'La table legal_pages est introuvable.',
            ]);
        }

        $data = $request->validate([
            'privacy_header_title' => ['nullable', 'string', 'max:255'],
            'privacy_header_subtitle' => ['nullable', 'string', 'max:255'],
            'privacy_header_background_color' => ['nullable', 'string', 'max:30'],
            'privacy_body' => ['nullable', 'string'],
            'terms_header_title' => ['nullable', 'string', 'max:255'],
            'terms_header_subtitle' => ['nullable', 'string', 'max:255'],
            'terms_header_background_color' => ['nullable', 'string', 'max:30'],
            'terms_body' => ['nullable', 'string'],
        ]);

        [$privacyPage, $termsPage] = $this->loadPages();

        $privacyPage->update([
            'header_title' => $data['privacy_header_title'] ?? $privacyPage->header_title,
            'header_subtitle' => $data['privacy_header_subtitle'] ?? $privacyPage->header_subtitle,
            'header_background_color' => $data['privacy_header_background_color'] ?? $privacyPage->header_background_color,
            'body' => $data['privacy_body'] ?? $privacyPage->body,
        ]);

        $termsPage->update([
            'header_title' => $data['terms_header_title'] ?? $termsPage->header_title,
            'header_subtitle' => $data['terms_header_subtitle'] ?? $termsPage->header_subtitle,
            'header_background_color' => $data['terms_header_background_color'] ?? $termsPage->header_background_color,
            'body' => $data['terms_body'] ?? $termsPage->body,
        ]);

        return redirect()->route('admin.legal.index')->with('success', 'Conditions et confidentialité mises à jour.');
    }

    private function loadPages(): array
    {
        $privacyPage = LegalPage::firstOrCreate(
            ['page' => LegalPage::PAGE_PRIVACY],
            [
                'header_title' => 'Mentions légales',
                'header_subtitle' => 'Informations légales',
                'header_background_color' => '#000000',
                'body' => LegalPage::defaultBody(LegalPage::PAGE_PRIVACY),
            ]
        );

        $termsPage = LegalPage::firstOrCreate(
            ['page' => LegalPage::PAGE_TERMS],
            [
                'header_title' => 'Conditions d’utilisations',
                'header_subtitle' => 'Informations légales',
                'header_background_color' => '#000000',
                'body' => LegalPage::defaultBody(LegalPage::PAGE_TERMS),
            ]
        );

        return [$privacyPage, $termsPage];
    }
}
