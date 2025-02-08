<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;

class UserService
{
  protected UserRepositoryInterface $userRepository;

  public function __construct(UserRepositoryInterface $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function createUser(array $data): User
  {
    return $this->userRepository->create($data);
  }

  public function getUserById(int $id): ?User
  {
    return User::find($id);
  }
}
