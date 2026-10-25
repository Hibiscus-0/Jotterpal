<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Entities\User;
use App\Libraries\TokenService;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    use ResponseTrait;

    public function register()
    {
        $data = $this->request->getJSON(true) ?? [];
        $data['email'] = strtolower(trim((string) ($data['email'] ?? '')));

        $rules = [
            'name'     => 'required|min_length[2]|max_length[100]',
            'email'    => 'required|valid_email|max_length[150]|is_unique[users.email]',
            'password' => 'required|min_length[8]|max_length[72]',
        ];

        if (! $this->validateData($data, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $users = new UserModel();
        $users->save(new User([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
            'role'     => 'user', // never taken from the request
        ]));

        $user = $users->find($users->getInsertID());

        return $this->respondCreated([
            'data' => $user->toSafeArray(),
            'auth' => (new TokenService())->issueAccessToken($user->id, $user->role),
        ]);
    }

    public function login() {
        $data = $this->request->getJSON(true) ?? [];

        $email = strtolower(trim((string) ($data['email'] ?? '')));
        $pass  = (string) ($data['password'] ?? '');

        $user = (new UserModel())->where('email', $email)->first();

        if (! $user || ! password_verify($pass, $user->password)) {
            return $this->failUnauthorized('Unvalid email or password');
        }

        return $this->respond([
            'data' => $user->toSafeArray(),
            'auth' => (new TokenService())->issueAccessToken($user->id, $user->role),
        ]);
    }

    public function me() {
        $id = (int) $this->request->getHeaderLine('X-Auth-User-Id');
        $user = (new UserModel())->find($id);

        return $user 
            ? $this->respond(['data' => $user->toSafeArray()]) 
            : $this->failNotFound('User not found!');
    }
}
