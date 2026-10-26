<?php

namespace App\DTOs\Responses;

enum HttpStatusCode: int
{
    case OK = 200;
    case CREATED = 201;
    case NO_CONTENT = 204;

    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;

    case INTERNAL_SERVER_ERROR = 500;
}

abstract class BaseResponse
{
    public function __construct(
        private HttpStatusCode $statusCode,
        private string $message 
    ) {}

    public function getStatusCode(): HttpStatusCode
    {
        return $this->statusCode;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function toArray(): array
    {
        return [
            'statusCode' => $this->statusCode->value,
            'message' => $this->message,
        ];
    }
}