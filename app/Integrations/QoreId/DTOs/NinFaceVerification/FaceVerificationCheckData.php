<?php

namespace App\Integrations\QoreId\DTOs\NinFaceVerification;

use Spatie\LaravelData\Data;

class FaceVerificationCheckData extends Data
{
    public function __construct(
        public ?bool $match,
        public ?float $match_score,
        public ?int $matching_threshold,
        public ?int $max_score,
    ) {}
}
