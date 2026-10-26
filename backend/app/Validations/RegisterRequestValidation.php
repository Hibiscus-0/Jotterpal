<?php 

namespace App\Validations;

use App\DTOs\Requests\RegisterRequest;
use Config\Services;

class RegisterRequestValidation 
{
    public function validate(RegisterRequest $request): array 
    {
        $validation = Services::validation();

        $rules = [
            'first_name'       => 'required|max_length[100]',
            'last_name'        => 'required|max_length[100]',
            'email'            => 'required|valid_email|max_length[150]|is_unique[users.email]',
            'password'         => 'required|min_length[8]|max_length[72]',
            'confirm_password' => 'required|matches[password]',
        ];

        $validation->setRules($rules);

        if(! $validation->run($request->toArray())) {
            return $validation->getErrors();
        }

        return [];
    }
}

?>