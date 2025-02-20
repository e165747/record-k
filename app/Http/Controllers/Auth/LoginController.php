<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;

final class LoginController extends Controller
{
  /**
   * @param AuthManager $auth
   */
  public function __construct(
    private readonly AuthManager $auth,
  ) {
  }

  /**
   * @param LoginRequest $request
   * @return JsonResponse
   * @throws AuthenticationException
   */
  public function __invoke(LoginRequest $request): JsonResponse
  {
    $credentials = $request->only(['email', 'password']);

    if ($this->auth->guard()->attempt($credentials)) {
      $request->session()->regenerate();

      return new JsonResponse([
        'message' => 'Authenticated.',
      ]);
    }

    // 認証が失敗した場合、カスタムエラーメッセージを含むJsonResponseを返す
    return new JsonResponse([
      // エラーメッセージを設定
      'error' => 'The username or password is incorrect.',
    ], 401); // HTTPステータスコード401を設定
  }
}
