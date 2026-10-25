<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenService {
    public function issueAccessToken(int $userId, string $role): array {
        $ttl = (int) env('JWT_TTL', 3600);
        $now = time();

        $token = JWT::encode([
            'iat' => $now,
            'exp' => $now + $ttl,
            'sub' => $userId,
            'role' => $role,
        ], env('JWT_SECRET'), 'HS256');

        return ['token' => $token, 'expires_in' => $ttl];
    }

    public function decodeAccessToken(string $token): object {
        return JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
    }
}