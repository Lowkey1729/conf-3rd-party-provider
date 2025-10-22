<?php

namespace App\DTOs;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class UnifiedBvnResponse extends Data
{
    public function __construct(
        public string  $bvn,
        #[Computed]
        public string  $firstName,
        #[Computed]
        public string  $lastName,
        #[Computed]
        public string  $middleName,
        #[Computed]
        public ?string $gender,
        public ?string $phoneNumber1,
        #[Computed]
        public ?string $dateOfBirth,
        public ?string $base64Image
    ) {
        if ($this->dateOfBirth) {
            $this->dateOfBirth = Carbon::parse($this->dateOfBirth)->format('y-m-d');
        }

        if ($this->gender) {
            $this->gender = $this->parseGender($this->gender);
        }

        $this->firstName = strtoupper($this->firstName ?? '');
        $this->lastName = strtoupper($this->lastName ?? '');
        $this->middleName = strtoupper($this->middleName ?? '');
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
