<?php

use App\Integrations\Dojah\DojahClient;
use App\Services\DojahIdentityVerificationService;
use App\DTOs\UnifiedBvnResponse;
use App\DTOs\UnifiedNinResponse;
use Tests\TestCase;


it('calls verifyBVNWithSelfie on the Dojah client and returns a unified response', function () {
    $mockResponse = (object) [
        'status' => 'success',
        'data' => (object) ['bvn' => '12345678901', 'face_match' => true],
    ];

    $mockedClient = Mockery::mock(DojahClient::class);
    $mockedClient
        ->shouldReceive('verifyBVNWithSelfie')
        ->once()
        ->with(['bvn' => '12345678901', 'selfie_image' => 'base64image'])
        ->andReturn($mockResponse);

    app()->instance(DojahClient::class, $mockedClient);

    $response = $this->service->verifyBvnWithSelfie('12345678901', 'base64image');

    expect($response)->toBeInstanceOf(UnifiedBvnResponse::class)
        ->and($response->bvn)->toBe('12345678901');
});

it('calls verifyNINWithSelfie on the Dojah client and returns a unified response', function () {
    $mockResponse = (object) [
        'status' => 'success',
        'data' => (object) ['nin' => '98765432100', 'face_match' => true],
    ];

    $mockedClient = Mockery::mock(DojahClient::class);
    $mockedClient
        ->shouldReceive('verifyNINWithSelfie')
        ->once()
        ->with(['nin' => '98765432100', 'selfie_image' => 'base64image'])
        ->andReturn($mockResponse);

    app()->instance(DojahClient::class, $mockedClient);

    $response = $this->service->verifyNinWithSelfie('98765432100', 'base64image');

    expect($response)->toBeInstanceOf(UnifiedNinResponse::class)
        ->and($response->nin)->toBe('98765432100');
});
