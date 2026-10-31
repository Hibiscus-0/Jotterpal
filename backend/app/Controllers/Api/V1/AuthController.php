<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\DTOs\Requests\LoginRequest;
use App\DTOs\Requests\RegisterRequest;
use App\DTOs\Responses\BaseResponse;
use App\DTOs\Responses\GenericResponse;
use App\DTOs\Responses\LoginResponse;
use App\DTOs\Responses\RegisterResponse;
use App\Exceptions\LoginFailedException;
use App\Models\UserModel;
use App\Services\AuthService;
use App\Validations\LoginRequestValidation;
use App\Validations\RegisterRequestValidation;
use CodeIgniter\API\ResponseTrait;
use Exception;

class AuthController extends BaseController
{
    use ResponseTrait;

    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function register()
    {
        $request = RegisterRequest::fromArray(
            $this->request->getJSON(true) ?? []
        );

        $errors = (new RegisterRequestValidation())->validate($request);

        if (! empty($errors)) {
            return $this->failValidationErrors($errors);
        }

        $this->authService->register($request);

        return $this->respondCreated([
            RegisterResponse::create()->toArray()
        ]);
    }

    public function login() {
        $request = LoginRequest::fromArray(
            $this->request->getJSON(true) ?? []
        );

        $errors = (new LoginRequestValidation())->validate($request);

        if (! empty($errors)) {
            return $this->failValidationErrors($errors);
        }

        try {
            $token = $this->authService->login($request);

            return $this->respond([
                LoginResponse::create($token)->toArray()
            ]);
        } catch (LoginFailedException $e) {
            return $this->failUnauthorized($e->getMessage());
        }
    }

    public function logout() {
        $authHeader = $this->request->getHeaderLine('Authorization');

        try {
            $this->authService->logout($authHeader);
            return $this->respond([
                GenericResponse::create()->toArray()
            ]);
        } catch (Exception $e) {
            return $this->failUnauthorized($e->getMessage());
        }
    }
}
