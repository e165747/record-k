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
      $table->decimal('self_evaluation', 5, 2)->nullable()->comment('自己評価')->change();
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
      $table->integer('self_evaluation')->nullable()->comment('自己評価')->change();
    });
  }
};
