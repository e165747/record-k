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
    Schema::table('records', function (Blueprint $table) {
      // メモカラムを追加する
      $table->text('memo')->nullable()->after('image_path');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('records', function (Blueprint $table) {
      $table->dropColumn('memo');
    });
  }
};
