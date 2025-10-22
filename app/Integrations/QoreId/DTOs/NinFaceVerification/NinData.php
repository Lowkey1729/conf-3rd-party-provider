<?php

namespace App\Integrations\QoreId\DTOs\NinFaceVerification;

use Spatie\LaravelData\Data;

class NinData extends Data
{
    public function __construct(
        public ?string $nin,
        public ?string $title,
        public ?string $firstname,
        public ?string $lastname,
        public ?string $middlename,
        public ?string $phone,
        public ?string $email,
        public ?string $gender,
        public ?string $height,
        public ?string $profession,
        public ?string $marital_status,
        public ?string $employment_status,
        public ?string $birthdate,
        public ?string $birth_state,
        public ?string $birth_country,
        public ?NextOfKinData $next_of_kin,
        public ?string $nspokenlang,
        public ?string $ospokenlang,
        public ?string $photo,
        public ?string $religion,
        public ?ResidenceData $residence,
        public ?string $lga_of_origin,
        public ?string $place_of_origin,
        public ?string $state_of_origin,
        public ?string $signature,
        public ?string $tracking_id,
    ) {}
}
