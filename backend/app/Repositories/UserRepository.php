<?php 

namespace App\Repositories;

use App\Entities\User;
use App\Models\UserModel;

class UserRepository {
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function findById(int $id): ?User {
        return $this->userModel->find($id);
    }

    public function findByEmail(string $email): ?User {
        return $this->userModel->where('email', $email)->first();
    }

    public function create(User $user): int {
        $this->userModel->save($user);

        return $this->userModel->getInsertID();
    }
}

?>