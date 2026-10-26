<?php 

namespace App\Services;

use App\DTOs\Requests\LoginRequest;
use App\DTOs\Requests\RegisterRequest;
use App\DTOs\Responses\TokenResponse;
use App\Entities\User;
use App\Exceptions\LoginFailedException;
use App\Libraries\TokenService;
use App\Models\UserModel;
use App\Repositories\UserRepository;
use CodeIgniter\Config\BaseService;

class AuthService extends BaseService
{
    private UserRepository $userRepository;
    private TokenService $tokenService;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->tokenService = new TokenService();
    }

    public function register(RegisterRequest $request): User
    {
       $createdUserId = $this->userRepository->create(new User([
            'first_name'    => $request->getFirstName(),
            'last_name'     => $request->getLastName(),
            'email'         => $request->getEmail(),
            'password'      => $request->getPassword(),
            'role'          => 'user'
       ]));

        return $this->userRepository->findById($createdUserId);
    }

    public function login(LoginRequest $request): TokenResponse
    {

        $user = $this->userRepository->findByEmail($request->getEmail());

        if (! $user || ! password_verify($request->getPassword(), $user->password)) {
            throw new LoginFailedException("Invalid username or password");
        }

        return $this->tokenService->issueAccessToken($user->id, $user->role);
    }
}

?>