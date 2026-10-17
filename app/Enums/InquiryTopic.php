<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum InquiryTopic: string implements HasLabel
{
    case Fix = 'fix';
    case Build = 'build';
    case Care = 'care';
    case General = 'general';

    public function getLabel(): string
    {
        return ucfirst($this->value);
    }
}
