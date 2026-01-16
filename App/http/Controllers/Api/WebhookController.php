<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function receive(Request $req)
    {
        $signature = $req->header('X-Signature');
        $payload = $req->getContent();
        $secret = config('app.key');

        $computed = 'v1=' . hash_hmac('sha256', $payload, $secret);

        if (!hash_equals($computed, $signature)) {
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        return response()->json(['status' => 'OK']);
    }
}
