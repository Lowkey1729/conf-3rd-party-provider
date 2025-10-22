<?php

namespace App\Services;

use App\Contracts\VerifyBvnWithSelfieInterface;
use App\Contracts\VerifyNinWithSelfieInterface;
use App\DTOs\UnifiedBvnResponse;
use App\DTOs\UnifiedNinResponse;
use App\Exceptions\IdentityVerificationException;
use App\Integrations\QoreId\QoreIdClient;

class QoreIdIdentityVerificationService implements VerifyBvnWithSelfieInterface, VerifyNinWithSelfieInterface
{
    protected QoreIdClient $client;

    public function __construct()
    {
        $this->client = resolve(QoreIdClient::class);
    }

    /**
     * @throws IdentityVerificationException
     */
    public function verifyNinWithSelfie(string $nin, string $selfie): UnifiedNinResponse
    {
        $response = $this->client->ninFaceVerification(['idNumber' => $nin, 'photoBase64' => $selfie]);

        if (! $response->nin?->nin) {
            throw new IdentityVerificationException($response->message ?? "Unable to verify NIN");
        }

        return UnifiedNinResponse::from([
            'nin' => $response->nin->nin,
            'firstName' => $response->nin->firstname,
            'lastName' => $response->nin->lastname,
            'middleName' => $response->nin->middlename,
            'gender' => $response->nin->gender,
            'phoneNumber1' => $response->nin->phone,
            'dateOfBirth' => $response->nin->birthdate,
            'base64Image' => $response->nin->phone,
        ]);
    }


    /**
     * @throws IdentityVerificationException
     */
    public function verifyBvnWithSelfie(string $bvn, string $selfie): UnifiedBvnResponse
    {
        $response = resolve(QoreIdClient::class)->bvnFaceVerification([
            'idNumber' => $bvn,
            'photoBase64' => $selfie,
        ]);

        if (! $response->nin) {
            throw new IdentityVerificationException($response->message ?? "Unable to verify BVN");
        }

        return UnifiedBvnResponse::from([
            'bvn' => $response->bvn->bvn,
            'firstName' => $response->bvn->firstname,
            'lastName' => $response->bvn->lastname,
            'middleName' => $response->bvn->middlename,
            'gender' => $response->bvn->gender,
            'phoneNumber1' => $response->bvn->phone,
            'dateOfBirth' => $response->bvn->birthdate,
            'base64Image' => $response->bvn->phone,
        ]);
    }
}
