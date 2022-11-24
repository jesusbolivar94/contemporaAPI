<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class Tokens extends SanctumPersonalAccessToken
{
    use HasApiTokens;

    protected $fillable = [
        'token',
        'abilities',
        'expires_at'
    ];

    /**
     * @return NewAccessToken
     */
    public function createToken(): NewAccessToken
    {
        $token = Tokens::create([
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => ['*'],
            'expires_at' => now()->addHour(1),
        ]);

        return new NewAccessToken($token, $plainTextToken);
    }
}
