<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
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

        ContactMessage::create($data);

        return back()
            ->with('contact_status', 'ok')
            ->withFragment('contact');
    }
}
