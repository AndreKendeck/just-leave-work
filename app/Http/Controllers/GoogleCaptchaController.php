<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GoogleCaptchaController extends Controller
{
    /**
     * @param Request $request
     * @return boolean
     */
    public function __invoke(Request $request): bool
    {
        $request->recaptcha;
        $secret = env('CAPTCHA_SECRET_KEY', '6Lf6dIEcAAAAADOb_cCUNdOmtTqTrODdkX-fqCSR');
        $guzzleClient = new Client([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $guzzleClient->post("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$request->recaptcha}&remoteip={$request->getClientIp()}");
            Log::info($response->getBody()->getContents());
            $body = json_decode($response->getBody());
            if ($body->success) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
