<?php

namespace App\Integrations\Dojah;

use App\Integrations\ClientTrait;
use App\Integrations\Dojah\DTOs\VerifyBVNWithSelfie\VerifyBVNWithSelfieResponse;
use App\Integrations\Dojah\DTOs\VerifyNINWithSelfie\VerifyNINWithSelfieResponse;
use Symfony\Component\HttpFoundation\Request;

class DojahClient
{
    use ClientTrait;

    public function __construct(
        protected string $appId,
        protected string $publicKey,
        protected string $privateKey,
        protected string $baseUrl,
    ) {
    }

    protected function baseUrl(): string
    {
        return $this->baseUrl;
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'AppId' => $this->appId,
            'Authorization' => $this->privateKey,
        ];
    }

    /**
     * @param array{bvn: string, selfie_image: string } $params
     * @return VerifyBVNWithSelfieResponse
     */
    public function verifyBVNWithSelfie(array $params): VerifyBVNWithSelfieResponse
    {
        $response = $this->sendRequest(
            method: Request::METHOD_POST,
            resource: '/v1/kyc/bvn/verify',
            data: $params
        );

        return VerifyBVNWithSelfieResponse::from($response->object());
    }


    public function verifyNINWithSelfie(array $params): VerifyNINWithSelfieResponse
    {
        $response = $this->sendRequest(
            method: Request::METHOD_POST,
            resource: '/v1/kyc/nin/verify',
            data: [
                'nin',
                'selfie_image',
            ]
        );

        return VerifyNINWithSelfieResponse::from($response->json());
    }
}
