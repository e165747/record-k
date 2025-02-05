<?php

namespace App\Repositories\Implements;

use App\Models\Author;
use App\Repositories\AuthorRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

class AuthorRepository implements AuthorRepositoryInterface
{
  public function index()
  {
    $userId = Auth::id();
    $cacheKey = 'authors_' . $userId;
    $authors = Cache::remember($cacheKey, 60 * 60, function () use ($userId) {
      $authors = Author::where('user_id', $userId)->get();
      // 画像のフルURLを生成
      foreach ($authors as $author) {
        if ($author->author_image) {
          $author->author_image = URL::asset('storage/artist/' . $userId . '/' . $author->author_id . '/' . $author->author_image);
        }
      }
      return $authors;
    });
    return $authors;
  }

  /**
   * @inheritDoc
   */
  public function getById(int $id): Author
  {
    return Author::find($id);
  }

  /**
   * @inheritDoc
   */
  public function store($data): Author
  {
    $author = Author::create($data);
    $this->forgetCache();
    return $author;
  }

  /**
   * @inheritDoc
   */
  public function update(array $data, int $authorId): Author
  {
    $author = Author::find($authorId);
    $author->update($data);
    $this->forgetCache();
    return $author;
  }

  /**
   * @inheritDoc
   */
  public function destroy($authorId)
  {
    $author = Author::find($authorId);
    $author->delete();
    $this->forgetCache();
  }

  /**
   * @inheritDoc
   */
  public function getList(): Collection
  {
    $userId = Auth::id();
    return Author::where('user_id', $userId)->pluck('author_name', 'author_id');
  }

  /**
   * キャッシュを削除する内部メソッド　
   * 
   * @return void
   */
  private function forgetCache()
  {
    $userId = Auth::id();
    $cacheKey = 'authors_' . $userId;
    if (Cache::has($cacheKey)) {
      Cache::forget($cacheKey);
    }
  }
}
