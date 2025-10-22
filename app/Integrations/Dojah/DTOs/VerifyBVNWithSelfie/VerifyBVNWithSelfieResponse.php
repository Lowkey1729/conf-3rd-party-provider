<?php

namespace App\Integrations\Dojah\DTOs\VerifyBVNWithSelfie;

use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class VerifyBVNWithSelfieResponse extends Data
{
    public function __construct(
        public ?EntityData $entity,
        public ?string $error,
    ) {
    }
}
