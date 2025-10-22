<?php

namespace App\Integrations\QoreId\DTOs\BvnFaceVerification;

use Spatie\LaravelData\Data;

class SummaryData extends Data
{
    public function __construct(
        public ?FaceVerificationCheckData $face_verification_check,
    ) {}
}
