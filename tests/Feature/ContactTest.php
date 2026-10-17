<?php

namespace Tests\Feature;

use App\Enums\InquiryTopic;
use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mockery;
use RuntimeException;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    private array $valid = [
        'name' => 'Asha',
        'email' => 'asha@example.com',
        'company' => 'Acme',
        'topic' => 'fix',
        'message' => 'Our checkout page is broken.',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        config(['mail.inquiry_to' => 'staff@example.com']);
    }

    public function test_contact_page_has_csrf_field_and_topics(): void
    {
        $this->get('/contact')->assertOk()->assertSee('name="_token"', false)->assertSee('value="general"', false);
    }

    public function test_valid_inquiry_is_saved_staff_notified_and_success_flashed(): void
    {
        $this->from('/contact')->post('/contact', $this->valid)
            ->assertRedirect('/contact')
            ->assertSessionHas('inquiry_sent', true);

        $inquiry = Inquiry::sole();
        $this->assertSame('Asha', $inquiry->name);
        $this->assertSame(InquiryTopic::Fix, $inquiry->topic);
        $this->assertNotNull($inquiry->notified_at);
    }

    public function test_invalid_input_is_rejected_with_the_standard_error_bag(): void
    {
        $this->from('/contact')->post('/contact', ['name' => '', 'email' => 'not-an-email', 'topic' => 'hack', 'message' => 'short'])
            ->assertRedirect('/contact')
            ->assertSessionHasErrors(['name', 'email', 'topic', 'message']);

        $this->assertSame(0, Inquiry::count());
    }

    public function test_redirect_never_leaves_the_site(): void
    {
        $this->post('/contact', $this->valid, ['Referer' => 'https://evil.test/phish'])
            ->assertRedirect(route('contact.show'));
    }

    public function test_honeypot_submission_looks_successful_but_is_not_stored(): void
    {
        $this->post('/contact', [...$this->valid, 'website' => 'http://spam.test'])
            ->assertSessionHas('inquiry_sent', true);

        $this->assertSame(0, Inquiry::count());
    }

    public function test_mail_failure_keeps_the_inquiry_and_logs_without_content(): void
    {
        Mail::shouldReceive('raw')->once()->andThrow(new RuntimeException('SMTP down'));
        Log::spy();

        $this->post('/contact', $this->valid)->assertSessionHas('inquiry_sent', true);

        $inquiry = Inquiry::sole();
        $this->assertNull($inquiry->notified_at);

        Log::shouldHaveReceived('error')->once()->with('Inquiry notification failed.', Mockery::on(
            fn (array $context) => $context['inquiry_id'] === $inquiry->id && ! str_contains(json_encode($context), 'checkout page')
        ));
    }

    public function test_missing_recipient_still_saves_the_inquiry(): void
    {
        config(['mail.inquiry_to' => null]);
        Mail::shouldReceive('raw')->never();

        $this->post('/contact', $this->valid)->assertSessionHas('inquiry_sent', true);

        $this->assertNull(Inquiry::sole()->notified_at);
    }

    public function test_submissions_are_rate_limited_per_ip(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $this->post('/contact', $this->valid)->assertSessionHas('inquiry_sent');
        }

        $this->from('/contact')->post('/contact', $this->valid)
            ->assertRedirect('/contact')
            ->assertSessionHasErrors('message')
            ->assertSessionMissing('inquiry_sent');

        $this->assertSame(3, Inquiry::count());
    }
}
