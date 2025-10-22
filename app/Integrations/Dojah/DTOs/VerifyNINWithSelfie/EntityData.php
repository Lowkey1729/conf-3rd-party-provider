<?php

namespace App\Integrations\Dojah\DTOs\VerifyNINWithSelfie;

use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class EntityData extends Data
{
    public function __construct(
        public string $nin,
        public ?string $first_name,
        public ?string $last_name,
        public ?string $middle_name,
        public ?string $date_of_birth,
        #[Computed]
        public ?string $gender,
        public ?string $image,
        public ?string $phone_number,
        public ?SelfieVerificationData $selfie_verification,
    ) {
        $this->gender = $this->gender === 'M' ? 'male' : 'female';
    }
}
