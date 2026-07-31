<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationToken extends Model
{
    protected $fillable = [
        'email',
        'token',
        'expires_at',
        'verified',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified' => 'boolean',
    ];

    public static function createToken($email)
    {
        $token = \Illuminate\Support\Str::random(60);

        static::updateOrCreate(
            ['email' => $email],
            [
                'token' => $token,
                'expires_at' => now()->addHours(24),
                'verified' => false,
            ]
        );

        return $token;
    }

    public static function isValidToken($email, $token)
    {
        return static::where('email', $email)
            ->where('token', $token)
            ->where('expires_at', '>', now())
            ->where('verified', false)
            ->exists();
    }

    public static function markAsVerified($email, $token)
    {
        return static::where('email', $email)
            ->where('token', $token)
            ->update(['verified' => true]);
    }
}
