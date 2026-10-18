<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PostStatus: string implements HasLabel
{
    case Draft = 'draft';
    case Published = 'published';

    public function getLabel(): string
    {
        return ucfirst($this->value);
    }
}
