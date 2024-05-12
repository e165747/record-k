<?php

namespace Database\Seeders;

use App\Models\Record;
use Illuminate\Database\Seeder;

class TestRecordsDataSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $exampleData = [
      [
        'record_name' => '泰安洋行',
        'description' => '細野晴臣のレコード',
        'is_possession' => false,
      ],
      [
        'record_name' => 'トロピカルダンディー',
        'description' => '細野晴臣のレコードその2',
        'is_possession' => true,
      ],
      [
        'record_name' => 'はらいそ',
        'description' => '細野晴臣のレコードその3',
        'is_possession' => true,
      ],
    ];
    // exampleData内のデータを全てrecordsに登録する
    foreach ($exampleData as $data) {
      Record::create([
        'record_name' => $data['record_name'],
        'description' => $data['description'],
        'is_possession' => $data['is_possession']
      ]);
    }
  }
}
