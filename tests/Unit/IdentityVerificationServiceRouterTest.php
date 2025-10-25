<?php

use App\Enums\ProviderEnum;
use App\Exceptions\IdentityVerificationException;
use App\Integrations\Dojah\DojahClient;
use App\Routers\IdentityVerificationServiceRouter;
use App\Services\DojahIdentityVerificationService;
use App\Services\QoreIdIdentityVerificationService;
use Tests\TestCase;


it('returns QoreId service when provider is QORE_ID', function () {
    $router = new IdentityVerificationServiceRouter(ProviderEnum::QORE_ID);
    $connector = $router->connector();

    expect($connector)->toBeInstanceOf(QoreIdIdentityVerificationService::class);
});

it('returns Dojah service when provider is DOJAH', function () {
    $router = new IdentityVerificationServiceRouter(ProviderEnum::DOJAH);
    $connector = $router->connector();

    expect($connector)->toBeInstanceOf(DojahIdentityVerificationService::class);
});

it('throws exception for invalid provider', function () {
    $router = new IdentityVerificationServiceRouter(ProviderEnum::INVALID);
    $router->connector();
})->throws(IdentityVerificationException::class);
