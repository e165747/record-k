<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('records', function (Blueprint $table) {
      $table->bigIncrements('record_id')->comment('レコードID');
      $table->timestamps();
      // レコード名
      $table->string('record_name', 100)->comment('レコード名');
      // レコード概要
      $table->string('description', 255)->nullable()->comment('レコード概要');
      // レコードの作成アーティスト
      // TODO 別途アーティストテーブルを作成してリレーションを張る
      // $table->string('artist_name', 100)->nullable()->comment('レコードの作成アーティスト');
      // レコードの所持状態
      $table->boolean('is_possession')->default(false)->comment('レコードの所持状態');
      // 自己評価
      $table->integer('self_evaluation')->nullable()->comment('自己評価');
      // レコードの画像
      $table->string('image_path')->nullable()->comment('レコードの画像');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('records');
  }
};
