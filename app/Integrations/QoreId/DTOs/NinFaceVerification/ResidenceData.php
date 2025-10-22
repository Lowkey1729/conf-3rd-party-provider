<?php

namespace App\Integrations\QoreId\DTOs\NinFaceVerification;

use Spatie\LaravelData\Data;

class ResidenceData extends Data
{
    public function __construct(
        public ?string $address1,
        public ?string $lga,
        public ?string $state,
    ) {}
}
