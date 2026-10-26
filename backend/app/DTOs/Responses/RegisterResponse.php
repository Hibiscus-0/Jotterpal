<?php

namespace App\DTOs\Responses;

use App\DTOs\Responses\BaseResponse;
use App\DTOs\Responses\HttpStatusCode;

class RegisterResponse extends BaseResponse
{
    public static function create(): self
    {
        return new self(
            HttpStatusCode::CREATED,
            'User registered successfully.'
        );
    }
}



?>