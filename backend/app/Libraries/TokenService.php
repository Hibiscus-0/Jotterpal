<?php

namespace App\Libraries;

use App\DTOs\Responses\TokenResponse;
use App\Repositories\UserRepository;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenService {
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function issueAccessToken(int $userId, string $role): TokenResponse {
        $ttl = (int) env('JWT_TTL', 3600);
        $now = time();

        $user = $this->userRepository->findById($userId);

        $token = JWT::encode([
            'iat' => $now,
            'exp' => $now + $ttl,
            'sub' => $userId,
            'name' => $user->getFullName(),
            'role' => $role,
        ], env('JWT_SECRET'), 'HS256');

        return TokenResponse::create($token, $ttl);
    }

    public function decodeAccessToken(string $token): object {
        return JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
    }
}