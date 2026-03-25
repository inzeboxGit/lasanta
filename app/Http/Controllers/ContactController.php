<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Throwable;

class ContactController extends Controller
{
    public function send(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name_contact' => ['required', 'string', 'max:120'],
            'lastname_contact' => ['nullable', 'string', 'max:120'],
            'email_contact' => ['required', 'email', 'max:255'],
            'phone_contact' => ['nullable', 'string', 'max:120'],
            'message_contact' => ['required', 'string', 'max:4000'],
            'verify_contact' => ['required', 'in:4'],
        ]);

        $recipient = env('MAIL_CONTACT_TO');

        if (empty($recipient) && Schema::hasTable('site_settings')) {
            $siteSetting = SiteSetting::where('setting_key', 'general')->first();

            if ($siteSetting) {
                $recipient = $siteSetting->use_site_email_for_contact
                    ? $siteSetting->email
                    : ($siteSetting->contact_recipient_email ?: $siteSetting->email);
            }
        }

        if (empty($recipient)) {
            $recipient = config('mail.from.address');
        }

        $fullName = trim(($data['name_contact'] ?? '') . ' ' . ($data['lastname_contact'] ?? ''));
        $subject = 'Nouveau message de contact - ' . config('app.name');

        $body = "Nom: {$fullName}\n"
            . "Email: {$data['email_contact']}\n"
            . "Téléphone: " . ($data['phone_contact'] ?: '-') . "\n"
            . "Date: " . now()->format('Y-m-d H:i:s') . "\n\n"
            . "Message:\n{$data['message_contact']}\n";

        try {
            Mail::raw($body, function ($message) use ($recipient, $subject, $data, $fullName) {
                $message->to($recipient)
                    ->subject($subject)
                    ->replyTo($data['email_contact'], $fullName ?: null);
            });

            return redirect()->back()->with('success', 'Votre message a été envoyé avec succès.');
        } catch (Throwable $e) {
            report($e);
            return redirect()->back()->with('error', "L'envoi de l'email a échoué. Vérifiez la configuration mail.");
        }
    }
}
