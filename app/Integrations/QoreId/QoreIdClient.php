<?php

namespace App\Integrations\QoreId;

use App\Integrations\ClientTrait;
use App\Integrations\QoreId\DTOs\BvnFaceVerification\BvnFaceVerificationResponse;
use App\Integrations\QoreId\DTOs\NinFaceVerification\NinFaceVerificationResponse;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Request;

class QoreIdClient
{
    use ClientTrait;

    protected string $cacheKey = 'qore_id:access_token';

    public function __construct(
        protected string $baseUrl,
        protected string $clientId,
        protected string $secretKey,
    ) {
    }

    protected function getAccessToken(): string
    {
        if (Cache::has($this->cacheKey)) {
            return Cache::get($this->cacheKey);
        }

        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post($this->baseUrl.'/token', ['clientId' => $this->clientId, 'secret' => $this->secretKey]);

        if (! $response->successful()) {
            throw new \RuntimeException('Unable to generate token. Reason: '.json_encode($response->json()));
        }

        $data = $response->json();

        Cache::put($this->cacheKey, $data['accessToken'], 6000);

        return $data['accessToken'];
    }

    /**
     * @param  array{idNumber: string, photoBase64: string}  $params
     *
     */
    public function bvnFaceVerification(array $params): BvnFaceVerificationResponse
    {
        $response = $this->sendRequest(
            method: Request::METHOD_POST,
            resource: '/v1/ng/identities/face-verification/bvn',
            data: $params
        );

        return BvnFaceVerificationResponse::from($response->object());
    }

    /**
     * @param  array{idNumber: string, photoBase64: string}  $params
     *
     */
    public function ninFaceVerification(array $params): NinFaceVerificationResponse
    {
        $response = $this->sendRequest(
            method: Request::METHOD_POST,
            resource: '/v1/ng/identities/face-verification/nin',
            data: $params
        );

        return NinFaceVerificationResponse::from($response->object());
    }

    protected function baseUrl(): string
    {
        return $this->baseUrl;
    }

    protected function defaultHeaders(): array
    {
        return [
            'Authorization' => 'Bearer '.$this->getAccessToken(),
        ];
    }
}
