<? 

namespace App\DTOs\Responses;

class LoginResponse extends BaseResponse
{
    public function __construct(
        private HttpStatusCode $statusCode, 
        private string $message,
        private TokenResponse $response
    ) {
        parent::__construct($statusCode, $message);
    }

    public static function create(TokenResponse $response) : self {
        return new self(
            HttpStatusCode::OK,
            'User logged in successfully.',
            $response
        );
    }

    public function getResponse() : TokenResponse {
        return $this->response;
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $data['accessToken'] = $this->response->toArray();

        return $data;
    }
}