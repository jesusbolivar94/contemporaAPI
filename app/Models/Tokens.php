<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class Tokens extends SanctumPersonalAccessToken
{
    use HasApiTokens;

    protected $fillable = [
        'token',
        'abilities',
        'expires_at'
    ];

    public function createToken()
    {
        $token = Tokens::create([
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => ['*'],
            'expires_at' => now()->addHour(3),
        ]);

        return new NewAccessToken($token, $plainTextToken);
    }
}
