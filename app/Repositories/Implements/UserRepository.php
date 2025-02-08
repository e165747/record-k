<?php

namespace App\Repositories\Implements;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
  public function all(): Collection
  {
    return User::all();
  }

  public function find(int $id): User
  {
    return User::findOrFail($id);
  }

  public function create(array $data): User
  {
    return User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
    ]);
  }

  public function update(int $id, array $data): User
  {
    $user = User::findOrFail($id);
    $user->update($data);
    return $user;
  }

  public function delete(int $id): bool
  {
    return User::destroy($id) > 0;
  }
}
