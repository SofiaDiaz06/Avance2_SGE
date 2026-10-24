<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReceivePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items' => ['required', 'array'],
            'items.*' => ['nullable', 'integer', 'min:0'],
            'provider_invoice' => ['nullable', 'string', 'max:50'],
        ];
    }
}