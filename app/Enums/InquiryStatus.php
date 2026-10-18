<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

enum InquiryStatus: string implements HasColor, HasIcon, HasLabel
{
    case New = 'new';
    case Read = 'read';
    case Replied = 'replied';
    case Archived = 'archived';

    public function getLabel(): string
    {
        return ucfirst($this->value);
    }

    public function getColor(): string
    {
        return match ($this) {
            self::New => 'primary',
            self::Read => 'warning',
            self::Replied => 'success',
            self::Archived => 'gray',
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::New => Heroicon::Sparkles,
            self::Read => Heroicon::Eye,
            self::Replied => Heroicon::CheckCircle,
            self::Archived => Heroicon::ArchiveBox,
        };
    }
}
