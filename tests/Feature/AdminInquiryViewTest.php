<?php

namespace Tests\Feature;

use App\Enums\InquiryStatus;
use App\Filament\Resources\Inquiries\InquiryResource;
use App\Filament\Resources\Inquiries\Pages\ListInquiries;
use App\Filament\Resources\Inquiries\Pages\ViewInquiry;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminInquiryViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_blocked_from_the_view_page(): void
    {
        $inquiry = Inquiry::factory()->create();

        $this->get("/admin/inquiries/{$inquiry->id}")->assertRedirect('/admin/login');
    }

    public function test_view_page_shows_the_submission_and_reply_link(): void
    {
        $inquiry = Inquiry::factory()->create(['name' => 'Ada Lovelace', 'email' => 'ada@example.com', 'message' => "Line one\nLine two"]);

        $this->actingAs(User::factory()->create())
            ->get("/admin/inquiries/{$inquiry->id}")
            ->assertOk()
            ->assertSee('Ada Lovelace')
            ->assertSee('ada@example.com')
            ->assertSee('Line one');

        Livewire::actingAs(User::factory()->create())
            ->test(ViewInquiry::class, ['record' => $inquiry->getRouteKey()])
            ->assertActionExists('reply');
    }

    public function test_status_actions_update_only_the_status(): void
    {
        $this->actingAs(User::factory()->create());
        $inquiry = Inquiry::factory()->create(['status' => InquiryStatus::New, 'message' => 'Untouched']);

        Livewire::test(ViewInquiry::class, ['record' => $inquiry->getRouteKey()])
            ->assertActionHidden('reopen')
            ->callAction('markReplied');
        $this->assertSame(InquiryStatus::Replied, $inquiry->fresh()->status);

        Livewire::test(ViewInquiry::class, ['record' => $inquiry->getRouteKey()])->callAction('archive');
        $this->assertSame(InquiryStatus::Archived, $inquiry->fresh()->status);

        Livewire::test(ViewInquiry::class, ['record' => $inquiry->getRouteKey()])->callAction('reopen');
        $this->assertSame(InquiryStatus::New, $inquiry->fresh()->status);
        $this->assertSame('Untouched', $inquiry->fresh()->message);
    }

    public function test_bulk_mark_as_read_only_touches_new_inquiries(): void
    {
        $this->actingAs(User::factory()->create());
        $new = Inquiry::factory()->create(['status' => InquiryStatus::New]);
        $replied = Inquiry::factory()->create(['status' => InquiryStatus::Replied]);

        Livewire::test(ListInquiries::class)->callTableBulkAction('markRead', [$new, $replied]);

        $this->assertSame(InquiryStatus::Read, $new->fresh()->status);
        $this->assertSame(InquiryStatus::Replied, $replied->fresh()->status);
    }

    public function test_navigation_badge_counts_new_inquiries(): void
    {
        $this->actingAs(User::factory()->create());
        $this->assertNull(InquiryResource::getNavigationBadge());

        Inquiry::factory()->count(2)->create(['status' => InquiryStatus::New]);
        Inquiry::factory()->create(['status' => InquiryStatus::Archived]);

        $this->assertSame('2', InquiryResource::getNavigationBadge());
    }

    public function test_dashboard_shows_stats_and_latest_inquiries(): void
    {
        Inquiry::factory()->create(['name' => 'Grace Hopper']);

        $this->actingAs(User::factory()->create())
            ->get('/admin')
            ->assertOk()
            ->assertSee('New inquiries')
            ->assertSee('Latest inquiries')
            ->assertSee('Grace Hopper')
            ->assertSee('Write a post')
            ->assertDontSee('Welcome');
    }
}
