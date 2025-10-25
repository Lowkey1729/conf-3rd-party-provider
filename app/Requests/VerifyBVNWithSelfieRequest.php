<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class VerifyBVNWithSelfieRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'bvn' => ['required', 'unique:profiles,bvn'],
            'selfie' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
