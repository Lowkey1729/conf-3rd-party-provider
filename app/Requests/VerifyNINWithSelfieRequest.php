<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyNINWithSelfieRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'nin' => ['required', 'unique:profiles,nin'],
            'selfie' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
