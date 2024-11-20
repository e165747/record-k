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
    Schema::table('authors', function (Blueprint $table) {
      // descriptionカラムを追加
      $table->text('description')->nullable()->after('author_name');
      // memoカラムを追加
      $table->text('memo')->nullable()->after('description');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('authors', function (Blueprint $table) {
      // descriptionカラムを削除
      $table->dropColumn('description');
      // memoカラムを削除
      $table->dropColumn('memo');
    });
  }
};
