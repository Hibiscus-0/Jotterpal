<?php

namespace App\Libraries;

use App\DTOs\Responses\RefreshTokenResponse;
use App\DTOs\Responses\TokenResponse;
use App\Repositories\UserRepository;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenService {
    private UserRepository $userRepository;
    private int $now;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->now = time();
    }

    public function issueAccessToken(int $userId, string $role): TokenResponse {
        $ttl = (int) env('ACCESS_TOKEN_EXPIRATION', 3600);

        $user = $this->userRepository->findById($userId);

        $token = JWT::encode([
            'iat' => $this->now,
            'exp' => $this->now + $ttl,
            'sub' => $userId,
            'name' => $user->getFullName(),
            'role' => $role,
        ], env('JWT_SECRET'), 'HS256');

        return TokenResponse::create($token, $ttl);
    }

    public function issueRefreshToken($length = 64, $algo = 'sha256'): RefreshTokenResponse {
        $ttl = (int) env('REFRESH_TOKEN_EXPIRATION', 2592000);

        $randomBytes = bin2hex(random_bytes($length));

        $token = hash($algo, $randomBytes);

        return RefreshTokenResponse::create($token, $this->now + $ttl);
    }

    public function decodeAccessToken(string $token): object {
        return JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
    }
}