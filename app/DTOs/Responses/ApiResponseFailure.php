<?php

namespace App\DTOs\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseFailure extends Data
{
    public static function make(string $message, int $statusCode = 400): self
    {
        return new self($message, $statusCode);
    }

    public function __construct(
        protected string $message,
        protected int $statusCode
    ) {}

    public function toResponse($request): JsonResponse|Response
    {
        return response()->json(
            [
                'status' => 'failed',
                'message' => $this->message,
            ],
            $this->statusCode
        );
    }
}
