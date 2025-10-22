<?php

namespace App\Integrations\Dojah\DTOs\VerifyNINWithSelfie;

use App\DTOs\UnifiedNinResponse;
use Spatie\LaravelData\Data;

class VerifyNINWithSelfieResponse extends Data
{
    public function __construct(
        public ?EntityData $entity,
        public ?string $error,
    ) {}

    public function toUnified(): UnifiedNinResponse
    {
        $entityArray = $this->entity->toArray();
        unset($entityArray['image']);

        return UnifiedNinResponse::from([
            'firstName' => $this->entity?->first_name,
            'lastName' => $this->entity?->last_name,
            'gender' => $this->entity?->gender,
            'phoneNumber1' => $this->entity?->phone_number,
            'middleName' => $this->entity?->middle_name,
            'base64Image' => $this->entity?->image,
            'dateOfBirth' => $this->entity?->date_of_birth,
            'providerData' => $entityArray,
        ]);
    }
}
