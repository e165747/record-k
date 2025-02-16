<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SignupControllerTest extends TestCase
{
  use RefreshDatabase;
  /**
   * ユーザー登録テスト
   * @test
   * @group user
   *
   * @return void
   */
  public function successSignup()
  {
    $data = [
      'name' => 'test@test.com',
      'email' => 'test@test.com',
      'password' => 'test_password',
      'password_confirmation' => 'test_password'
    ];
    $this->postJson('/api/signup', $data)
      ->assertStatus(201)
      ->assertJson([
        'message' => 'User created successfully.'
      ]);
  }

  /**
   * ユーザー登録テスト（バリデーションエラー）
   * @test
   * @group user
   *
   * @return void
   */
  public function failedSignup()
  {
    $data = [
      'name' => 'test@test.com',
      'email' => 'test@test.com',
      'password' => 'test_password',
      'password_confirmation' => 'test_password2'
    ];
    $this->postJson('/api/signup', $data)
      ->assertStatus(422)
      ->assertJson([
        'message' => 'The password confirmation does not match.'
      ]);

    $data = [
      'name' => 'test@test.com',
      'email' => 'test.com',
      'password' => 'test_password',
      'password_confirmation' => 'test_password'
    ];
    $this->postJson('/api/signup', $data)
      ->assertStatus(422)
      ->assertJson([
        'message' => 'The email must be a valid email address.'
      ]);

    $data = [
      'name' => 'test@test.com',
      'email' => 'test@test.com',
      'password' => 'test',
      'password_confirmation' => 'test'
    ];
    $this->postJson('/api/signup', $data)
      ->assertStatus(422)
      ->assertJson([
        'message' => 'The password must be at least 6 characters.'
      ]);
  }

  /**
   * ユーザー登録テスト（重複エラー）
   * @test
   * @group user
   */
  public function failedSignupDuplicate()
  {
    $data = [
      'name' => 'test@test.com',
      'email' => 'test@test.com',
      'password' => 'test_password',
      'password_confirmation' => 'test_password'
    ];
    $this->postJson('/api/signup', $data)
      ->assertStatus(201)
      ->assertJson([
        'message' => 'User created successfully.'
      ]);

    $this->postJson('/api/signup', $data)
      ->assertStatus(422)
      ->assertJson([
        'message' => 'The email has already been taken.'
      ]);
  }
}
