<?php

namespace App\Integrations\QoreId\DTOs\BvnFaceVerification;

use Spatie\LaravelData\Data;

class BvnData extends Data
{
    public function __construct(
        public ?string $bvn,
        public ?string $firstname,
        public ?string $lastname,
        public ?string $middlename,
        public ?string $birthdate,
        public ?string $gender,
        public ?string $phone,
        public ?string $photo,
        public ?string $lga_of_residence,
        public ?string $marital_status,
        public ?string $nationality,
        public ?string $residential_address,
        public ?string $state_of_residence,
        public ?string $email,
        public ?string $enrollment_bank,
        public ?string $watch_listed,
    ) {}
}
