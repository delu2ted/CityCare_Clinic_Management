<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        try {
            Mail::raw(
                "From: {$validated['name']} ({$validated['email']})\n\n{$validated['message']}",
                function ($mail) use ($validated) {
                    $mail->to('info@citycareclinic.test')
                        ->subject('New Contact Form Inquiry')
                        ->replyTo($validated['email'], $validated['name']);
                }
            );
        } catch (\Exception $e) {
            // Mail server not configured (e.g. local dev) — fail silently, log it
            \Log::info('Contact form submitted (mail not sent): ' . json_encode($validated));
        }

        return back()->with('contact_sent', true);
    }
}