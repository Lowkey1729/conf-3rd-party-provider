<?php

namespace App\Integrations\QoreId\DTOs\BvnFaceVerification;

use Spatie\LaravelData\Data;

class StatusData extends Data
{
    public function __construct(
        public ?string $state,
        public ?string $status,
    ) {}
}
