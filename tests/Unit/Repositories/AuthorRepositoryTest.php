<?php

namespace Tests\Unit\Repositories;

use App\Models\Author;
use App\Repositories\Implements\AuthorRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Mockery;
use PHPUnit\Framework\TestCase;

// 今は使っていない
class AuthorRepositoryTest extends TestCase
{
  protected function setUp(): void
  {
    parent::setUp();

    // asset関数のモック
    $this->mockAssetFunction();
  }

  public function tearDown(): void
  {
    // Mockeryのモックを閉じる
    Mockery::close();
    parent::tearDown();
  }
  /**
   * A basic unit test example.
   * @test
   * @group author
   * @return void
   */
  public function test_example()
  {
    $this->assertTrue(true);
  }

  /**
   * キャッシュがない場合の一覧取得
   * @test
   * @group author
   * @return void
   */
  public function indexWithoutCache()
  {
    $userId = 1;
    $authors = collect([
      (object) ['author_id' => 1, 'author_image' => 'image1.jpg', 'user_id' => 1],
      (object) ['author_id' => 2, 'author_image' => 'image2.jpg', 'user_id' => 1],
    ]);

    // Authファサードのモック
    Auth::shouldReceive('id')->once()->andReturn($userId);

    // Cacheファサードのモック
    Cache::shouldReceive('remember')->once()->andReturnUsing(function ($key, $ttl, $callback) {
      return $callback();
    });

    // Authorモデルのモック
    $authorMock = Mockery::mock('overload:' . Author::class);
    $authorMock->shouldReceive('where')->with('user_id', $userId)->andReturnSelf();
    $authorMock->shouldReceive('get')->andReturn($authors);

    // asset関数のモック
    $this->mockAssetFunction();

    // リポジトリのインスタンス化とメソッドの呼び出し
    $repository = new AuthorRepository();
    $result = $repository->index();

    // アサーション
    $this->assertCount(2, $result);
    $this->assertEquals('http://localhost/storage/artist/1/1/image1.jpg', $result[0]->author_image);
    $this->assertEquals('http://localhost/storage/artist/1/2/image2.jpg', $result[1]->author_image);
  }

  /**
   * キャッシュがある場合の一覧取得
   * @test
   * @group author
   * @return void
   */
  public function indexWithCache()
  {
    $userId = 1;
    $authors = collect([
      (object) ['author_id' => 1, 'author_image' => 'http://localhost/storage/artist/1/1/image1.jpg', 'user_id' => 1],
      (object) ['author_id' => 2, 'author_image' => 'http://localhost/storage/artist/1/2/image2.jpg', 'user_id' => 1],
    ]);

    // Authファサードのモック
    Auth::shouldReceive('id')->once()->andReturn($userId);

    // Cacheファサードのモック
    Cache::shouldReceive('remember')->once()->andReturn($authors);

    // Authorモデルのモック
    $authorMock = Mockery::mock('overload:' . Author::class);
    $authorMock->shouldReceive('where')->with('user_id', $userId)->andReturnSelf();
    $authorMock->shouldReceive('get')->andReturn($authors);

    // asset関数のモック
    $this->mockAssetFunction();

    // リポジトリのインスタンス化とメソッドの呼び出し
    $repository = new AuthorRepository();
    $result = $repository->index();

    // アサーション
    $this->assertCount(2, $result);
    $this->assertEquals('http://localhost/storage/artist/1/1/image1.jpg', $result[0]->author_image);
    $this->assertEquals('http://localhost/storage/artist/1/2/image2.jpg', $result[1]->author_image);
  }

  private function mockAssetFunction()
  {
    // asset関数のモック
    URL::shouldReceive('asset')->andReturnUsing(function ($path) {
      return 'http://localhost/' . $path;
    });
  }
}
