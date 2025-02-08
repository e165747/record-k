<?php

namespace Tests\Unit\Repositories;

use App\Repositories\Implements\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
// PHPUnit ではなく Laravelの TestCase を使う。
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
  use RefreshDatabase; // テスト後にDBをリセット

  protected UserRepository $userRepository;

  protected function setUp(): void
  {
    parent::setUp();
    $this->userRepository = new UserRepository();
  }
  /**
   * ユーザー登録テスト
   * @test
   * @group user
   *
   * @return void
   */
  public function create_test()
  {
    $data = [
      'name' => 'test',
      'email' => 'test@test.com',
      'password' => 'test_password'
    ];

    $user = $this->userRepository->create($data);
    $this->assertEquals($data['name'], $user->name);
    $this->assertEquals($data['email'], $user->email);
    // パスワードがハッシュ化されているか
    $this->assertNotEquals($data['password'], $user->password);
  }
}
