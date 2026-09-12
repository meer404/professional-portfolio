<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Notifications\NewContactMessage;
use App\Settings\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    public function store(Request $request, SiteSettings $settings): RedirectResponse
    {
        // Honeypot: real users never fill this hidden field.
        if (filled($request->input('website'))) {
            return back()->with('contact_status', 'ok');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        $message = ContactMessage::create($data);

        if ($settings->contact_email) {
            Notification::route('mail', $settings->contact_email)
                ->notify(new NewContactMessage($message));
        }

        return back()
            ->with('contact_status', 'ok')
            ->withFragment('contact');
    }
}
