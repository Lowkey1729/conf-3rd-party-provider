<?php

namespace App\Integrations\QoreId\DTOs\BvnFaceVerification;

use App\DTOs\UnifiedBvnResponse;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Transformation\TransformationContext;
use Spatie\LaravelData\Support\Transformation\TransformationContextFactory;
use Spatie\LaravelData\Support\Wrapping\WrapExecutionType;

class BvnFaceVerificationResponse extends Data
{
    public function __construct(
        public ?int $id,
        public ?SummaryData $summary,
        public StatusData|int|null $status,
        public ?BvnData $bvn,
        public ?string $statusCode,
        public ?string $message,
    ) {}
}
