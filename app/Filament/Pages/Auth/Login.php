<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseLogin
{
    public function getHeading(): string|Htmlable|null
    {
        return filled($this->userUndertakingMultiFactorAuthentication) ? parent::getHeading() : 'Studio sign in';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return parent::getSubheading() ?? 'Staff access to the journal and the inbox.';
    }
}
