<?php

namespace App\DTOs\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;
use Symfony\Component\HttpFoundation\Response;

class ApiResponsePending extends Data
{
    /**
     * @param  array<int|string, mixed>  $data
     * @param  array<int|string, mixed>  $topLevelData
     */
    public static function make(
        string $message,
        array $data = [],
        array $topLevelData = [],
        int $statusCode = 200
    ): self {
        return new self(
            $message,
            $data,
            $topLevelData,
            $statusCode
        );
    }

    public function __construct(
        protected string $message,
        /**
         * @var array<int|string, mixed> $data
         */
        protected array $data = [],
        /**
         * @var array<int|string, mixed> $topLevelData
         */
        protected array $topLevelData = [],
        protected int $statusCode = 200
    ) {}

    public function toResponse($request): JsonResponse|Response
    {
        $var = [
            'status' => 'pending',
        ];

        if ($this->message) {
            $var['message'] = $this->message;
        }

        if (count($this->data) > 0) {
            $var['result']['data'] = $this->data;
        }

        return response()->json(
            $var,
            $this->statusCode
        );
    }
}
