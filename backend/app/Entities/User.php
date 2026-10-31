<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $datamap = [];
    protected $dates   = ['email_verified_at', 'refresh_token_expires_at', 'created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'id' => 'integer', 
        'first_name' => 'string', 
        'last_name' => 'string', 
        'email' => 'string', 
        'password' => 'string', 
        'role' => 'string',
        'refresh_token' => 'string'
    ];

    public function  setRefreshToken($refreshToken) {
        $this->attributes['refresh_token'] = $refreshToken;
        return $this;
    }
    
    public function  setRefreshTokenExpiresAt($refreshTokenExpiresAt) {
        $this->attributes['refresh_token_expires_at'] = $refreshTokenExpiresAt;
        return $this;
    }

    public function setPassword(string $password) {
        $this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    public function getFullName(): string
    {
        return trim(
            $this->first_name . ' ' . $this->last_name
        );
    }

    public function toSafeArray(): array
    {
        $data = $this->toArray();
        unset($data['password'], $data['deleted_at']);
        return $data;
    }

}
