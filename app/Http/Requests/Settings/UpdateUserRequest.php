<?php

namespace App\Http\Requests\Settings;

use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends StoreUserRequest
{
    protected function passwordRules(): array
    {
        return ['nullable', 'confirmed', Password::defaults()];
    }
}