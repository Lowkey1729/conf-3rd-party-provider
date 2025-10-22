<?php

namespace App\Integrations\Dojah\DTOs\VerifyBVNWithSelfie;

use Spatie\LaravelData\Data;

class SelfieVerificationData extends Data
{
    public function __construct(
        public ?string $confidence_value,
        public ?bool $match,
    ) {}
}
