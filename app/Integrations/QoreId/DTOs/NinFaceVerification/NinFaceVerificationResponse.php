<?php

namespace App\Integrations\QoreId\DTOs\NinFaceVerification;

use Spatie\LaravelData\Data;

class NinFaceVerificationResponse extends Data
{
    public function __construct(
        public ?int $id,
        public ?SummaryData $summary,
        public ?StatusData $status,
        public ?NinData $nin,
        public ?string $statusCode = '400',
        public ?string $message = 'Unable to complete request',
    ) {}
}
