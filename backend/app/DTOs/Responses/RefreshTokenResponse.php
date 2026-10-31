<?php

namespace App\DTOs\Responses;

class RefreshTokenResponse 
{
    public function __construct(
        private string $refreshToken,
        private int $expiresIn,
    ) {}

    public static function create(string $refreshToken, int $expiresIn): self
    {
        return new self(
            $refreshToken,
            $expiresIn
        );
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    public function toArray(): array
    {
        return [
            'refresh_token' => $this->refreshToken,
            'expires_in' => $this->expiresIn
        ];
    }
}

?>