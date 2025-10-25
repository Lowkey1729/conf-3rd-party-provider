<?php

namespace App\Integrations\QoreId\DTOs\NinFaceVerification;

use Spatie\LaravelData\Data;

class NinFaceVerificationResponse extends Data
{
    public function __construct(
        public ?int $id,
        public ?SummaryData $summary,
        public StatusData|int|null $status,
        public ?NinData $nin,
        public ?string $statusCode,
        public ?string $message,
    ) {}
}
