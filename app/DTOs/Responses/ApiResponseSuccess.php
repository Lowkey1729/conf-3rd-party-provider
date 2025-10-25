<?php

namespace App\DTOs\Responses;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\CursorPaginator;
use Spatie\LaravelData\Data;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseSuccess extends Data
{
    /**
     * @template TValue
     *
     * @param  array<int|string, mixed>|LengthAwarePaginator<int, TValue>|CursorPaginator<int, TValue>  $data
     * @param  array<string, mixed>  $topLevelData
     */
    public static function make(
        string $message,
        array|LengthAwarePaginator|CursorPaginator $data = [],
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

    /**
     * @template TValue
     *
     * @param  array<int|string, mixed>|LengthAwarePaginator<int, TValue>|CursorPaginator<int, TValue>  $data
     * @param  array<string, mixed>  $topLevelData
     */
    public function __construct(
        protected string $message,
        protected array|LengthAwarePaginator|CursorPaginator $data = [],
        protected array $topLevelData = [],
        protected int $statusCode = 200
    ) {}

    public function toResponse($request): JsonResponse|Response
    {
        $var = [
            'status' => 'success',
        ];

        if ($this->message) {
            $var['message'] = $this->message;
        }

        if (count($this->topLevelData) > 0) {
            foreach ($this->topLevelData as $key => $item) {
                $var[$key] = $item;
            }
        }

        return response()->json(
            $var,
            $this->statusCode
        );
    }
}
