<?php

namespace App\Filament\Resources\Inquiries\Pages;

use App\Enums\InquiryStatus;
use App\Filament\Resources\Inquiries\InquiryResource;
use App\Models\Inquiry;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewInquiry extends ViewRecord
{
    protected static string $resource = InquiryResource::class;

    public function getTitle(): string
    {
        return $this->getRecord()->name;
    }

    public function getSubheading(): ?string
    {
        return 'Inquiry received '.$this->getRecord()->created_at->diffForHumans();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('reply')
                ->label('Reply by email')
                ->icon(Heroicon::OutlinedEnvelope)
                ->url(fn (Inquiry $record) => 'mailto:'.rawurlencode($record->email).'?subject='.rawurlencode('Re: your message to TRETA')),
            ActionGroup::make([
                self::statusAction('markRead', 'Mark as read', InquiryStatus::Read, Heroicon::OutlinedEye),
                self::statusAction('markReplied', 'Mark as replied', InquiryStatus::Replied, Heroicon::OutlinedCheckCircle),
                self::statusAction('archive', 'Archive', InquiryStatus::Archived, Heroicon::OutlinedArchiveBox),
                self::statusAction('reopen', 'Reopen', InquiryStatus::New, Heroicon::OutlinedArrowUturnLeft),
            ])->label('Status')->icon(Heroicon::OutlinedChevronDown)->button()->color('gray'),
            EditAction::make()->label('Notes')->icon(Heroicon::OutlinedPencilSquare)->color('gray'),
        ];
    }

    // Each action hides itself once the inquiry already has that status.
    private static function statusAction(string $name, string $label, InquiryStatus $to, Heroicon $icon): Action
    {
        return Action::make($name)
            ->label($label)
            ->icon($icon)
            ->visible(fn (Inquiry $record) => $record->status !== $to)
            ->action(function (Inquiry $record, ViewInquiry $livewire) use ($to) {
                $record->update(['status' => $to]);
                $livewire->refreshFormData(['status']);
                Notification::make()->title("Marked as {$to->getLabel()}")->success()->send();
            });
    }
}
