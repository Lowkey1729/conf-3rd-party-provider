<?php

namespace App\Exceptions;

use App\DTOs\Responses\ApiResponseFailure;
use Exception;
use Illuminate\Contracts\Support\Responsable;

class ProviderException extends Exception
{
    public function render(): Responsable
    {
        return ApiResponseFailure::make(
            message: $this->message,
            statusCode: $this->code == 0 ? 400 : $this->code,
        );
    }
}
