<?php

namespace App\Http\Middleware;

use App\Models\Record;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * ユーザーに紐づくレコードデータか確認するミドルウェア
 */
class EnsureUserOwnsRecord
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next)
  {
    $userId = Auth::id();
    $recordId = $request->route('id');

    if ($recordId && !Record::where('id', $recordId)->where('user_id', $userId)->exists()) {
      return response()->json(['error' => 'Unauthorized'], 403);
    }

    return $next($request);
  }
}
