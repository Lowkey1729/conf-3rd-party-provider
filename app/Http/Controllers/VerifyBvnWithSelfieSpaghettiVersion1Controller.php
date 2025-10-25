<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VerifyBvnWithSelfieSpaghettiVersion1Controller extends Controller
{
    public function __invoke(Request $request)
    {
        $profile = Profile::first();

        if ($profile->bvn) {
            return response()->json(['error' => 'BVN already verified'], 400);
        }

        $provider = $request->get('provider') ?? 'dojah'; // manually pass provider in request
        $bvn = $request->get('bvn');
        $selfie = $request->get('selfie');

        // Some random preprocessing that shouldn't be here
        $selfie = str_replace(' ', '+', $selfie);
        $selfie = trim($selfie);
        if (strlen($selfie) < 100) {
            return response()->json(['error' => 'Invalid selfie image'], 422);
        }

        if ($provider === 'dojah') {
            $url = 'https://api.dojah.io/v1/kyc/bvn/verify';
            $headers = [
                'Content-Type' => 'application/json',
                'AppId' => env('DOJAH_APP_ID'),
                'Authorization' => env('DOJAH_PRIVATE_KEY'),
            ];
            $payload = [
                'bvn' => $bvn,
                'selfie_image' => $selfie,
            ];

            $response = Http::withHeaders($headers)->post($url, $payload);

            if ($response->status() != 200) {
                if (isset($response['error'])) {
                    return response()->json(['error' => $response['error']], 400);
                } else {
                    return response()->json(['error' => 'BVN verification failed'], 400);
                }
            }

            if (! isset($response['entity']['bvn'])) {
                return response()->json(['error' => 'Invalid response from Dojah'], 400);
            }

            $entity = $response['entity'];

            $profile->bvn = $entity['bvn'] ?? null;
            $profile->first_name = $entity['first_name'] ?? '';
            $profile->middle_name = $entity['middle_name'] ?? '';
            $profile->last_name = $entity['last_name'] ?? '';
            $profile->gender = $entity['gender'] ?? '';
            $profile->dob = $entity['date_of_birth'] ?? null;
            $profile->save();

        } elseif ($provider === 'qore_id') {
            // Get token first
            $tokenResponse = Http::post('https://api.qoreid.io/token', [
                'clientId' => 'QORE_ID_CLIENT_ID_123',
                'secret' => 'QORE_ID_SECRET_456',
            ]);

            if (! $tokenResponse->ok()) {
                return response()->json(['error' => 'Unable to get token'], 400);
            }

            $accessToken = $tokenResponse['accessToken'] ?? null;

            if (! $accessToken) {
                return response()->json(['error' => 'No access token returned'], 400);
            }

            $bvnUrl = 'https://api.qoreid.io/v1/ng/identities/face-verification/bvn';
            $ninUrl = 'https://api.qoreid.io/v1/ng/identities/face-verification/nin';
            $type = $request->get('type', 'bvn');

            if ($type === 'bvn') {
                $response = Http::withHeaders(['Authorization' => 'Bearer '.$accessToken])
                    ->post($bvnUrl, [
                        'idNumber' => $bvn,
                        'photoBase64' => $selfie,
                    ]);
            } else {
                $response = Http::withHeaders(['Authorization' => 'Bearer '.$accessToken])
                    ->post($ninUrl, [
                        'idNumber' => $request->get('nin'),
                        'photoBase64' => $selfie,
                    ]);
            }

            if (! $response->successful()) {
                return response()->json(['error' => 'Verification failed from QoreId'], 400);
            }

            if ($type === 'bvn') {
                $data = $response['bvn'] ?? [];
                $profile->bvn = $data['bvn'] ?? '';
                $profile->first_name = $data['firstname'] ?? '';
                $profile->last_name = $data['lastname'] ?? '';
                $profile->middle_name = $data['middlename'] ?? '';
                $profile->dob = $data['birthdate'] ?? '';
                $profile->gender = $data['gender'] ?? '';
                $profile->phone_number_1 = $data['phone'] ?? '';
            } else {
                $data = $response['nin'] ?? [];
                $profile->nin = $data['nin'] ?? '';
                $profile->first_name = $data['firstname'] ?? '';
                $profile->last_name = $data['lastname'] ?? '';
                $profile->middle_name = $data['middlename'] ?? '';
                $profile->dob = $data['birthdate'] ?? '';
                $profile->gender = $data['gender'] ?? '';
                $profile->phone_number_1 = $data['phone'] ?? '';
            }

            $profile->save();
        } else {
            return response()->json(['error' => 'Provider not supported'], 400);
        }

        \Log::info("BVN verification done for {$profile->first_name} {$profile->last_name}");

        return [
            'status' => 'success',
            'message' => 'Verification completed',
        ];
    }
}
