<?php

namespace App\Http\Requests;

use App\Enums\InquiryTopic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInquiryRequest extends FormRequest
{
    /** Hidden honeypot field; humans leave it empty. */
    public const HONEYPOT = 'website';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email:rfc', 'max:255'],
            'company' => ['nullable', 'string', 'max:150'],
            'topic' => ['required', Rule::enum(InquiryTopic::class)],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ];
    }

    public function isSpam(): bool
    {
        return filled($this->input(self::HONEYPOT));
    }
}
