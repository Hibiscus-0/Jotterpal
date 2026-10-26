<?php

namespace App\DTOs\Responses;

class TokenResponse 
{
    public function __construct(
        private string $accessToken,
        private int $expiresIn,
    ) {}

    public static function create(string $accessToken, int $expiresIn): self
    {
        return new self(
            $accessToken,
            $expiresIn
        );
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    public function toArray(): array
    {
        return [
            'access_token' => $this->accessToken,
            'expires_in' => $this->expiresIn
        ];
    }
}

?>