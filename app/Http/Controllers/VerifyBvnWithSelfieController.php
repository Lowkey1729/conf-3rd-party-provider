<?php

namespace App\Http\Controllers;

use App\DTOs\Responses\ApiResponseSuccess;
use App\Enums\ServiceEnum;
use App\Exceptions\IdentityVerificationException;
use App\Models\Profile;
use App\Requests\VerifyBVNWithSelfieRequest;
use App\Routers\IdentityVerificationServiceRouter;

class VerifyBvnWithSelfieController extends Controller
{
    /**
     * @throws IdentityVerificationException
     */
    public function __invoke(VerifyBvnWithSelfieRequest $request)
    {

        $provider = getActiveProvider(ServiceEnum::BVN);

        // you might want to compress your selfie image before sending it down to the upstream client

        $kycRouter = new IdentityVerificationServiceRouter($provider);
        $response = $kycRouter->connector()->verifyBvnWithSelfie($request->get('bvn'), $request->get('selfie'));

        // You might as well want to save the image selfie after successful validation here

        Profile::query()->updateOrCreate([
            'bvn' => $request->get('bvn'),
        ],[
            'gender' => $response->gender,
            'phone_number_1' => $response->phoneNumber1,
            'first_name' => $response->firstName,
            'middle_name' => $response->middleName,
            'last_name' => $response->lastName,
            'dob' => $response->dateOfBirth,
        ]);

        return ApiResponseSuccess::make(
            "Bvn verification successful",
        );
    }
}
