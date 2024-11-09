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
      // authorsテーブルがもつauthor_idカラムを追加
      $table->unsignedBigInteger('author_id')->after('record_id');
      // レコード購入日
      $table->date('purchase_date')->nullable()->after('author_id');
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
      $table->dropColumn('author_id');
      $table->dropColumn('purchase_date');
    });
  }
};
