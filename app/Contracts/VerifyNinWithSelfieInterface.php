<?php

namespace App\Contracts;

use App\DTOs\UnifiedNinResponse;

interface VerifyNinWithSelfieInterface
{
    public function verifyNinWithSelfie(string $nin, string $selfie): UnifiedNinResponse;
}
