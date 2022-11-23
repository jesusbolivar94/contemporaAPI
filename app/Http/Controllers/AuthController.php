<?php

namespace App\Http\Controllers;

use App\Models\Tokens;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getToken(): JsonResponse
    {
        $token = new Tokens();

        $access_token = $token->createToken();

        return response()
            ->json([
                'access_token' => $access_token->plainTextToken
            ]);
    }
}
