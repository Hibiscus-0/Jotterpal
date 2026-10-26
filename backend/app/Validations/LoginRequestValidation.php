<?php 

namespace App\Validations;

use App\DTOs\Requests\LoginRequest;
use Config\Services;


class LoginRequestValidation 
{
    public function validate(LoginRequest $request): array
    {
        $validation = Services::validation();

        $rules = [
            'email'     => 'required|valid_email',
            'password'  => 'required',
        ];

        $validation->setRules($rules);

        if(! $validation->run($request->toArray())) {
            return $validation->getErrors();
        }

        return [];
    }
}