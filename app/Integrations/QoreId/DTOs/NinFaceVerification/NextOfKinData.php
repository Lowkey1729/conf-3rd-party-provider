<?php

namespace App\Integrations\QoreId\DTOs\NinFaceVerification;

use Spatie\LaravelData\Data;

class NextOfKinData extends Data
{
    public function __construct(
        public ?string $firstname,
        public ?string $lastname,
        public ?string $middlename,
        public ?string $address1,
        public ?string $lga,
        public ?string $state,
        public ?string $town,
    ) {}
}
