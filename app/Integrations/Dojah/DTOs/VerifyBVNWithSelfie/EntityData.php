<?php

namespace App\Integrations\Dojah\DTOs\VerifyBVNWithSelfie;

use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class EntityData extends Data
{
    public function __construct(
        public string $bvn,
        public ?string $first_name,
        public ?string $last_name,
        public ?string $middle_name,
        public ?string $date_of_birth,
        #[Computed]
        public ?string $gender,
        public ?string $image,
        public ?string $phone_number1,
        public ?string $phone_number2,
        public ?SelfieVerificationData $selfie_verification,
    ) {
        $this->gender = strtolower($this->gender);
    }
}
