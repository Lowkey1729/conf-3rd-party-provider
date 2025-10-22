<?php

namespace App\Integrations\QoreId\DTOs\NinFaceVerification;

use App\DTOs\UnifiedNinResponse;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Transformation\TransformationContext;
use Spatie\LaravelData\Support\Transformation\TransformationContextFactory;
use Spatie\LaravelData\Support\Wrapping\WrapExecutionType;

class NinFaceVerificationResponse extends Data
{
    public function __construct(
        public ?int         $id,
        public ?SummaryData $summary,
        public ?StatusData  $status,
        public ?NinData     $nin,
        public ?string $statusCode = '400',
        public ?string $message = 'Unable to complete request',
    ) {}
}
