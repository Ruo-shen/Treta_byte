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

        return redirect()->to(self::sameSiteBack())->with('inquiry_sent', true);
    }

    /**
     * Previous page when it is on this exact site (scheme, host and port of APP_URL), otherwise the contact page.
     * Rejects backslashes, userinfo and non-http(s) schemes, which parsers disagree about (open-redirect tricks).
     */
    public static function sameSiteBack(): string
    {
        $previous = url()->previous();
        $site = parse_url((string) config('app.url'));
        $url = parse_url($previous);

        $port = fn (?array $u) => $u['port'] ?? (strtolower((string) ($u['scheme'] ?? '')) === 'https' ? 443 : 80);
        $safe = is_array($url) && is_array($site)
            && ! str_contains($previous, chr(92))
            && ! isset($url['user']) && ! isset($url['pass'])
            && in_array(strtolower((string) ($url['scheme'] ?? '')), ['http', 'https'], true)
            && strtolower((string) ($url['scheme'] ?? '')) === strtolower((string) ($site['scheme'] ?? ''))
            && strtolower((string) ($url['host'] ?? '')) === strtolower((string) ($site['host'] ?? ''))
            && $port($url) === $port($site);

        return $safe ? $previous : route('contact.show');
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
