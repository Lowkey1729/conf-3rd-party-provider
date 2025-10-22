<?php

namespace App\Integrations\QoreId\DTOs\BvnFaceVerification;

use App\DTOs\UnifiedBvnResponse;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Transformation\TransformationContext;
use Spatie\LaravelData\Support\Transformation\TransformationContextFactory;
use Spatie\LaravelData\Support\Wrapping\WrapExecutionType;

class BvnFaceVerificationResponse extends Data
{
    public function __construct(
        public ?int $id,
        public ?SummaryData $summary,
        public ?StatusData $status,
        public ?BvnData $bvn,
        public ?string $statusCode = '400',
        public ?string $message = 'Unable to complete request',
    ) {}

    public function transform(
        bool|TransformationContextFactory|TransformationContext|null $transformationContext = true,
        WrapExecutionType $wrapExecutionType = WrapExecutionType::Disabled,
        bool $mapPropertyNames = true
    ): array {
        $entityArray = $this->bvn->toArray();
        unset($entityArray['photo']);

        return UnifiedBvnResponse::from([
            'firstName' => $this->bvn?->firstname,
            'lastName' => $this->bvn?->lastname,
            'gender' => $this->bvn?->gender,
            'phoneNumber1' => $this->bvn?->phone,
            'middleName' => $this->bvn?->middlename,
            'base64Image' => $this->bvn?->photo,
            'dateOfBirth' => $this->bvn?->birthdate,
            'providerData' => $entityArray,
        ])->toArray();
    }
}
