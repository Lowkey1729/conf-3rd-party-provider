<?php

namespace App\DTOs;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class UnifiedNinResponse extends Data
{
    public function __construct(
        public string $nin,
        public string $firstName,
        public string $lastName,
        public ?string $middleName,
        #[Computed]
        public ?string $gender,
        public ?string $phoneNumber1,
        public ?string $phoneNumber2,
        #[Computed]
        public ?string $dateOfBirth,
        public ?string $base64Image
    ) {
        $this->firstName = strtoupper($this->firstName);
        $this->lastName = strtoupper($this->lastName);
        $this->middleName = strtoupper($this->middleName);

        if ($this->dateOfBirth) {
            $this->dateOfBirth = Carbon::parse($this->dateOfBirth)->format('y-m-d');
        }

        if ($this->gender) {
            $this->gender = $this->parseGender($this->gender);
        }
    }

    protected function parseGender(string $gender): string
    {
        $gender = strtolower($gender);

        return match ($gender) {
            'm' => 'male',
            'f' => 'female',
            default => $gender,
        };
    }
}
