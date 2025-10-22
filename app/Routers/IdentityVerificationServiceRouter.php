<?php

namespace App\Routers;

use App\Contracts\VerifyBvnWithSelfieInterface;
use App\Contracts\VerifyNinWithSelfieInterface;
use App\Enums\ProviderEnum;
use App\Exceptions\IdentityVerificationException;
use App\Services\DojahIdentityVerificationService;
use App\Services\QoreIdIdentityVerificationService;

class IdentityVerificationServiceRouter
{
    public function __construct(
        public ProviderEnum $driver
    ) {}

    /**
     * @throws IdentityVerificationException
     */
    public function connector(): VerifyNinWithSelfieInterface|VerifyBvnWithSelfieInterface
    {
        return match ($this->driver) {
            ProviderEnum::QORE_ID => new QoreIdIdentityVerificationService,
            ProviderEnum::DOJAH => new DojahIdentityVerificationService,
            default => throw new IdentityVerificationException('Invalid router selected.'),
        };
    }
}
