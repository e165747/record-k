<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
  /**
   * ユーザー一覧を取得
   * @return Collection
   */
  public function all(): Collection;
  /**
   * 該当ユーザーを取得
   * @param int $id
   * @return \App\Models\User
   */
  public function find(int $id): User;

  /**
   * ユーザーを作成
   * @param array $data
   * @return \App\Models\User
   */
  public function create(array $data): User;

  /**
   * ユーザーを更新
   * @param int $id
   * @param array $data
   * @return \App\Models\User
   */
  public function update(int $id, array $data): User;

  /**
   * ユーザーを削除
   * @param int $id
   * @return bool
   */
  public function delete(int $id): bool;
}
