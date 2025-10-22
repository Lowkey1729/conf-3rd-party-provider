<?php

namespace App\Integrations\QoreId\DTOs\NinFaceVerification;

use Spatie\LaravelData\Data;

class StatusData extends Data
{
    public function __construct(
        public ?string $state,
        public ?string $status,
    ) {}
}
