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
    Schema::create('authors', function (Blueprint $table) {
      $table->id('author_id');
      // 外部のユーザーID
      $table->unsignedBigInteger('user_id');
      $table->string('author_name');
      // 自己評価
      $table->integer('self_evaluation')->default(3);
      // 画像
      $table->string('author_image')->nullable();
      // いつからこのアーティストを知ったかを記録(例:2022-01-01)
      $table->date('know_date')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('authors');
  }
};
