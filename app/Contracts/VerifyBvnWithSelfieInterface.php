<?php

namespace App\Contracts;

use App\DTOs\UnifiedBvnResponse;

interface VerifyBvnWithSelfieInterface
{
    public function verifyBvnWithSelfie(string $bvn, string $selfie): UnifiedBvnResponse;
}
