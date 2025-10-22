<?php

namespace App\Integrations;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait ClientTrait
{
    /**
     * Send an HTTP request using the configured client.
     *
     * @param string $method
     * @param string $resource
     * @param array<int|string, mixed> $data
     * @param string $bodyFormat
     * @param array<string, string> $headers
     * @param int $timeout
     * @return Response
     */
    protected function sendRequest(
        string $method,
        string $resource,
        array  $data = [],
        string $bodyFormat = 'json',
        array  $headers = [],
        int $timeout = 10
    ): Response {
        try {
            $fullUrl = rtrim($this->baseUrl(), '/') . '/' . ltrim($resource, '/');

            $mergedHeaders = array_merge($this->defaultHeaders(), $headers);

            $response = Http::withHeaders($mergedHeaders)
                ->baseUrl($this->baseUrl())
                ->timeout($timeout)
                ->send($method, $resource, [$bodyFormat => $data]);

            $this->logRequest($method, $fullUrl, $data, $mergedHeaders, $response);

            return $response;
        } catch (ConnectionException) {
            return $this->buildEmptyResponse(504);
        } catch (\Illuminate\Http\Client\RequestException) {
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



    /**
     * Log a request/response pair.
     */
    protected function logRequest(
        string $method,
        string $url,
        array $payload,
        array $headers,
        Response $response
    ): void {
        Log::channel('daily')->info("{$this->getClientName()} Request", [
            'method' => strtoupper($method),
            'url' => $url,
            'payload' => $payload,
            'headers' => $headers,
            'status' => $response->status(),
            'response' => $response->json(),
        ]);
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
     *
     * @return array<string, string>
     */
    abstract protected function defaultHeaders(): array;


    protected function getClientName(): string
    {
        return class_basename(static::class);
    }
}
