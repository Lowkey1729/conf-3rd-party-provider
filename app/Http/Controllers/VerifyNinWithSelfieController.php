<?php

namespace App\Http\Controllers;

use App\DTOs\Responses\ApiResponseSuccess;
use App\Enums\ProviderEnum;
use App\Enums\ServiceEnum;
use App\Exceptions\IdentityVerificationException;
use App\Exceptions\ProviderException;
use App\Models\Profile;
use App\Requests\VerifyNINWithSelfieRequest;
use App\Routers\IdentityVerificationServiceRouter;

class VerifyNinWithSelfieController extends Controller
{
    /**
     * @throws IdentityVerificationException
     * @throws ProviderException
     */
    public function __invoke(VerifyNinWithSelfieRequest $request)
    {
        $provider = getActiveProvider(ServiceEnum::NIN);

        // you might want to compress your selfie image before sending it down to the upstream client

        $kycRouter = new IdentityVerificationServiceRouter($provider);
        $response = $kycRouter->connector()->verifyNinWithSelfie($request->get('nin'), $request->get('selfie'));

        // You might as well want to save the image selfie after successful validation here

        Profile::query()->updateOrCreate([
            'nin' => $response->nin,
        ],[
            'gender' => $response->gender,
            'phone_number_1' => $response->phoneNumber1,
            'phone_number_2' => $response->phoneNumber2,
            'first_name' => $response->firstName,
            'middle_name' => $response->middleName,
            'last_name' => $response->lastName,
            'dob' => $response->dateOfBirth,
        ]);

        return ApiResponseSuccess::make(
            "NIN verification successful",
        );
    }
}
