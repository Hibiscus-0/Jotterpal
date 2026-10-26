<?php 

namespace App\DTOs\Requests;

class LoginRequest
{

    public function __construct(
        private string $email,
        private string $password
    ) {}

    public static function fromArray(array $data) : self 
    {
        return new self(
            strtolower(trim($data['email'] ?? '')),
            $data['password'] ?? ''
        );
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function toArray(): array {
        return [
            'email' => $this->email,
            'password' => $this->password
        ];
    }

}

?>