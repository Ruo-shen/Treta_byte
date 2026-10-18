<?php

namespace Tests\Feature;

use App\Enums\InquiryTopic;
use App\Models\Inquiry;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
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
        // A real mailer whose transport fails, so the whole send path is exercised.
        Mail::extend('failing', fn () => new class extends AbstractTransport
        {
            protected function doSend(SentMessage $message): void
            {
                throw new TransportException('SMTP down');
            }

            public function __toString(): string
            {
                return 'failing://';
            }
        });
        config(['mail.mailers.failing' => ['transport' => 'failing'], 'mail.default' => 'failing']);
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

    public function test_daily_cap_blocks_the_21st_submission(): void
    {
        for ($i = 0; $i < 20; $i++) {
            if ($i > 0 && $i % 3 === 0) {
                $this->travel(61)->seconds();
            }
            $this->post('/contact', $this->valid)->assertSessionHas('inquiry_sent');
        }

        $this->travel(61)->seconds();
        $this->post('/contact', $this->valid)->assertSessionHasErrors('message');

        $this->assertSame(20, Inquiry::count());
    }

    /** @return array<string, array{0: string}> */
    public static function hostileReferers(): array
    {
        return [
            'other host' => ['https://evil.test/phish'],
            'backslash trick' => ['https://evil.test\@localhost/x'],
            'userinfo' => ['http://localhost@evil.test/x'],
            'userinfo on own host' => ['http://user:pw@localhost/x'],
            'other port' => ['http://localhost:8080/x'],
            'other scheme' => ['https://localhost/x'],
            'javascript' => ['javascript://localhost/%0Aalert(1)'],
            'protocol relative' => ['//evil.test/x'],
        ];
    }

    #[DataProvider('hostileReferers')]
    public function test_hostile_referers_fall_back_to_the_contact_page_on_success_and_on_throttle(string $referer): void
    {
        $this->post('/contact', $this->valid, ['Referer' => $referer])->assertRedirect(route('contact.show'));

        // Same fallback from the rate-limiter response.
        for ($i = 0; $i < 3; $i++) {
            $this->post('/contact', $this->valid, ['Referer' => $referer]);
        }
        $this->post('/contact', $this->valid, ['Referer' => $referer])->assertRedirect(route('contact.show'));
    }

    public function test_same_site_referer_is_kept(): void
    {
        $this->post('/contact', $this->valid, ['Referer' => 'http://localhost/services?x=1'])
            ->assertRedirect('http://localhost/services?x=1');
    }

    public function test_post_without_csrf_token_is_rejected_with_419(): void
    {
        // Laravel skips CSRF verification under test; re-enable it for this request.
        $this->app->bind(ValidateCsrfToken::class, fn ($app) => new class($app, $app->make('encrypter')) extends ValidateCsrfToken
        {
            protected function runningUnitTests()
            {
                return false;
            }
        });

        $this->post('/contact', $this->valid)->assertStatus(419);
        $this->assertSame(0, Inquiry::count());

        $this->get('/contact');
        $this->post('/contact', [...$this->valid, '_token' => csrf_token()])->assertSessionHas('inquiry_sent');
        $this->assertSame(1, Inquiry::count());
    }
}
