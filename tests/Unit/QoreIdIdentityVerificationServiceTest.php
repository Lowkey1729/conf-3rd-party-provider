<?php

use App\Integrations\QoreId\QoreIdClient;
use App\Services\QoreIdIdentityVerificationService;
use App\DTOs\UnifiedNinResponse;
use App\DTOs\UnifiedBvnResponse;
use Tests\TestCase;

beforeEach(function () {
    $this->service = new QoreIdIdentityVerificationService();
});

it('calls bvnFaceVerification on the QoreId client and returns a unified response', function () {
    $mockResponse = (object)[
        'id' => "12345678901",
        'bvn' => (object) [
            'bvn' => "12345678901",
            'firstname' => 'John',
            'lastname' => "Doe",
            'middlename' => "Mighty",
            'phone' => "1234567890",
        ]
    ];

    $mockedClient = Mockery::mock(QoreIdClient::class);
    $mockedClient
        ->shouldReceive('bvnFaceVerification')
        ->once()
        ->with(['idNumber' => '12345678901', 'photoBase64' => 'base64image'])
        ->andReturn($mockResponse);

    app()->instance(QoreIdClient::class, $mockedClient);

    $response = $this->service->verifyBvnWithSelfie('12345678901', 'base64image');

    expect($response)->toBeInstanceOf(UnifiedBvnResponse::class)
        ->and($response->bvn)->toBe('12345678901')
        ->and($response->firstName)->toBe('John')
        ->and($response->lastName)->toBe('Doe')
        ->and($response->middlename)->toBe('Mighty')
        ->and($response->phoneNumber1)->toBe('1234567890');
});

it('calls ninFaceVerification on the QoreId client and returns a unified response', function () {
    $mockResponse = (object)[
        'id' => "98765432100",
        'nin' => (object) [
            'nin' => "98765432100",
            'firstname' => 'John',
            'lastname' => "Doe",
            'middlename' => "Mighty",
            'phone' => "1234567890",
        ]
    ];

    $mockedClient = Mockery::mock(QoreIdClient::class);
    $mockedClient
        ->shouldReceive('ninFaceVerification')
        ->once()
        ->with(['idNumber' => '98765432100', 'photoBase64' => 'base64image'])
        ->andReturn($mockResponse);

    app()->instance(QoreIdClient::class, $mockedClient);

    $response = $this->service->verifyNinWithSelfie('98765432100', 'base64image');

    expect($response)->toBeInstanceOf(UnifiedNinResponse::class)
        ->and($response->nin)->toBe('98765432100')
        ->and($response->firstName)->toBe('John')
        ->and($response->lastName)->toBe('Doe')
        ->and($response->middlename)->toBe('Mighty')
        ->and($response->phoneNumber1)->toBe('1234567890');
});
