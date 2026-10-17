<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    public function store(StoreInquiryRequest $request): RedirectResponse
    {
        // Bots get the same success response but nothing is stored.
        if (! $request->isSpam()) {
            $inquiry = Inquiry::create($request->validated());
            $this->notifyStaff($inquiry);
        }

        return back()->with('inquiry_sent', true);
    }

    /** Saving and notifying are separate outcomes: a mail failure never loses the saved inquiry. */
    private function notifyStaff(Inquiry $inquiry): void
    {
        $to = config('mail.inquiry_to');

        if (blank($to)) {
            Log::warning('Inquiry notification skipped: INQUIRY_NOTIFY_ADDRESS is not set.', ['inquiry_id' => $inquiry->id]);

            return;
        }

        try {
            Mail::raw($this->body($inquiry), function ($message) use ($to, $inquiry) {
                $message->to($to)
                    ->replyTo($inquiry->email, $inquiry->name)
                    ->subject('New '.$inquiry->topic->getLabel().' inquiry #'.$inquiry->id);
            });

            $inquiry->forceFill(['notified_at' => now()])->save();
        } catch (Throwable $e) {
            // Log the id and failure only; the submission content stays in the database.
            Log::error('Inquiry notification failed.', ['inquiry_id' => $inquiry->id, 'exception' => $e::class, 'error' => $e->getMessage()]);
        }
    }

    private function body(Inquiry $inquiry): string
    {
        return implode("\n", [
            'Name: '.$inquiry->name,
            'Email: '.$inquiry->email,
            'Company: '.($inquiry->company ?: '-'),
            'Topic: '.$inquiry->topic->getLabel(),
            '',
            $inquiry->message,
            '',
            'Manage: '.url('/admin/inquiries/'.$inquiry->id.'/edit'),
        ]);
    }
}
