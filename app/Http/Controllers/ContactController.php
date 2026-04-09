<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactEnquiryMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Contact');
    }

    public function send(ContactFormRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();

        try {
            Mail::to(config('mail.contact_recipient', config('mail.from.address')))
                ->send(new ContactEnquiryMail(
                    senderName:      $validated['name'],
                    senderEmail:     $validated['email'],
                    phone:           $validated['phone'] ?? null,
                    yearLevel:       $validated['year_level'] ?? null,
                    enquiryMessage:  $validated['message'],
                ));
        } catch (\Throwable $e) {
            Log::error('Contact form mail delivery failed', [
                'error' => $e->getMessage(),
                'email' => $validated['email'],
            ]);

            return back()->withErrors([
                'form' => 'Sorry, we were unable to send your message right now. Please try again or contact us directly via WhatsApp.',
            ])->withInput();
        }

        return back()->with('success', true);
    }
}
