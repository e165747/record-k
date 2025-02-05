<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Author::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'user_id' => \App\Models\User::factory(), // 関連するユーザーのID
      // author_idは一意かつオートインクリメントなので、ここでは定義しない
      'author_id' => $this->faker->unique()->numberBetween(1, 1000), // 一意の著者ID
      'author_name' => $this->faker->name, // 著者の名前
      'author_image' => null, // 著者の画像
      // self_evaluationは1~5の範囲でランダムな数値を生成
      'self_evaluation' => $this->faker->numberBetween(1, 5),
    ];
  }

  /**
   * Configure the factory.
   *
   * @return $this
   */
  public function configure()
  {
    // 画像を生成して保存
    return $this->afterCreating(function (Author $author) {
      $userId = $author->user_id;
      $authorId = $author->author_id;
      $directory = "public/storage/artist/{$userId}/{$authorId}";

      // ディレクトリが存在しない場合は作成
      if (!Storage::exists($directory)) {
        Storage::makeDirectory($directory);
      }

      // 画像を生成して保存
      $imagePath = $this->faker->image(storage_path("app/{$directory}"), 640, 480, null, false);
      $author->author_image = "{$imagePath}";
      $author->save();
    });
  }
}
