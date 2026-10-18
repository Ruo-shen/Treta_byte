<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum InquiryStatus: string implements HasLabel
{
    case New = 'new';
    case Read = 'read';
    case Replied = 'replied';
    case Archived = 'archived';

    public function getLabel(): string
    {
        return ucfirst($this->value);
    }
}
