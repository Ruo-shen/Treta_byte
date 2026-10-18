<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum InquiryTopic: string implements HasColor, HasLabel
{
    case Fix = 'fix';
    case Build = 'build';
    case Care = 'care';
    case General = 'general';

    public function getLabel(): string
    {
        return ucfirst($this->value);
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Fix => 'danger',
            self::Build => 'primary',
            self::Care => 'success',
            self::General => 'gray',
        };
    }
}
