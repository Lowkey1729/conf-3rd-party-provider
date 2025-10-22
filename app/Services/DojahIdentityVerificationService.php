<?php

namespace App\Services;

use App\Contracts\VerifyBvnWithSelfieInterface;
use App\Contracts\VerifyNinWithSelfieInterface;
use App\DTOs\UnifiedBvnResponse;
use App\DTOs\UnifiedNinResponse;
use App\Exceptions\IdentityVerificationException;
use App\Integrations\Dojah\DojahClient;

class DojahIdentityVerificationService implements VerifyBvnWithSelfieInterface, VerifyNinWithSelfieInterface
{
    protected DojahClient $client;

    public function __construct()
    {
        $this->client = resolve(DojahClient::class);
    }

    /**
     * @throws IdentityVerificationException
     */
    public function verifyNinWithSelfie(string $nin, string $selfie): UnifiedNinResponse
    {
        $response = $this->client->verifyNINWithSelfie(['nin' => $nin, 'selfie_image' => $selfie]);

        if (! $response->entity?->nin) {
            throw new IdentityVerificationException($response->error ?? 'Unable to verify NIN. Please try again.');
        }

        return UnifiedNinResponse::from([
            'nin' => $response->entity?->nin,
            'firstName' => $response->entity?->first_name,
            'lastName' => $response->entity?->last_name,
            'middleName' => $response->entity?->middle_name,
            'gender' => $response->entity?->gender,
            'phoneNumber1' => $response->entity?->phone_number,
            'dateOfBirth' => $response->entity?->date_of_birth,
            'base64Image' => $response->entity?->image,
        ]);
    }

    /**
     * @throws IdentityVerificationException
     */
    public function verifyBvnWithSelfie(string $bvn, string $selfie): UnifiedBvnResponse
    {
        $response = $this->client->verifyBVNWithSelfie(['bvn' => $bvn, 'selfie_image' => $selfie]);

        if (! $response->entity?->bvn) {
            throw new IdentityVerificationException($response->error ?? 'Unable to verify BVN. Please try again.');
        }

        return UnifiedBvnResponse::from([
            'bvn' => $response->entity?->bvn,
            'firstName' => $response->entity?->first_name,
            'lastName' => $response->entity?->last_name,
            'middleName' => $response->entity?->middle_name,
            'gender' => $response->entity?->gender,
            'phoneNumber1' => $response->entity?->phone_number1,
            'phoneNumber2' => $response->entity?->phone_number2,
            'dateOfBirth' => $response->entity?->date_of_birth,
            'base64Image' => $response->entity?->image,
        ]);
    }
}
