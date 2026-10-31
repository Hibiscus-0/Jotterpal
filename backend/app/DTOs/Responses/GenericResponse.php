<?php

namespace App\DTOs\Responses;

use App\DTOs\Responses\BaseResponse;
use App\DTOs\Responses\HttpStatusCode;

class GenericResponse extends BaseResponse
{
    public static function create(): self
    {
        return new self(
            HttpStatusCode::OK,
            'User logged out successfully.'
        );
    }
}



?>