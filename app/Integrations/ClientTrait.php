<?php

namespace App\Integrations;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait ClientTrait
{
    /**
     * Send an HTTP request using the configured client.
     *
     * @param  array<int|string, mixed>  $data
     * @param  array<string, string>  $headers
     */
    protected function sendRequest(
        string $method,
        string $resource,
        array $data = [],
        string $bodyFormat = 'json',
        array $headers = [],
        int $timeout = 10
    ): Response {
        try {
            $fullUrl = rtrim($this->baseUrl(), '/').'/'.ltrim($resource, '/');

            $mergedHeaders = array_merge($this->defaultHeaders(), $headers);

            $response = Http::withHeaders($mergedHeaders)
                ->baseUrl($this->baseUrl())
                ->timeout($timeout)
                ->send($method, $resource, [$bodyFormat => $data]);

            Log::channel('daily')->info("{$this->getClientName()} Request", [
                'method' => strtoupper($method),
                'url' => $fullUrl,
                'payload' => $data,
                'headers' => $headers,
                'status' => $response->status(),
                'response' => $response->json(),
            ]);

            return $response;
        } catch (ConnectionException) {
            Log::error("Connection Timeout in {$this->getClientName()}");
            return $this->buildEmptyResponse(504);
        } catch (\Illuminate\Http\Client\RequestException) {
            Log::error("Bad Request in {$this->getClientName()}");
            return $this->buildEmptyResponse(400);
        } catch (\Throwable $e) {
            Log::error("Unexpected error in {$this->getClientName()}", [
                'message' => $e->getMessage(),
                'url' => $resource,
                'method' => $method,
                'data' => $data,
                'headers' => $headers,
            ]);

            return $this->buildEmptyResponse(500);
        }
    }

    protected function buildEmptyResponse(int $status): Response
    {
        return new Response(new GuzzleResponse(
            $status,
            ['Content-Type' => 'application/json'],
            json_encode([])
        ));
    }

    abstract protected function baseUrl(): string;

    /**
     * @return array<string, string>
     */
    abstract protected function defaultHeaders(): array;

    protected function getClientName(): string
    {
        return class_basename(static::class);
    }
}
