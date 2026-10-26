<?php

namespace App\DTOs\Requests;

class RegisterRequest
{
    
    public function __construct(
        private string $firstName,
        private string $lastName,
        private string $email,
        private string $password,
        private string $confirmPassword
    ) {}

    public static function fromArray(array $data) : self 
    {
        return new self(
            trim($data['first_name'] ?? ''),
            trim($data['last_name'] ?? ''),
            strtolower(trim($data['email'] ?? '')),
            $data['password'] ?? '',
            $data['confirm_password']
        );
    }

    public function getFirstName(): string 
    {
        return $this->firstName;
    }

    public function getLastName(): string 
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }


    public function toArray(): array {
        return [
            'first_name'        => $this->firstName,
            'last_name'         => $this->lastName,
            'email'             => $this->email,
            'password'          => $this->password,
            'confirm_password'  => $this->confirmPassword
        ];
    }
}