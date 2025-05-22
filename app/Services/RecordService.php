<?php

namespace App\Services;

class RecordService
{
  /**
   *  AIにmessedageを送信する(疎通確認用)
   *
   * @param array $data
   * @return string
   */
  public function sendMessageToAi(array $data): string
  {
    // API KEYをセット
    $apiKey = env('AI_API_KEY');

    // AIへの質問。（postで取得）
    $user_message = "こんにちは";

    // 役割を設定。空欄可。
    $system_set = "関西弁で回答してください。";

    // 各種項目をセット。（max_tokenも必須項目。）
    $param = json_encode([
      "model" => "claude-3-opus-20240229",
      "max_tokens" => 1024,
      "system" => $system_set,
      "messages" => [
        ["role" => "user", "content" => $user_message]
      ]
    ]);

    // 回答を取得
    $ch = curl_init('https://api.anthropic.com/v1/messages');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "Content-Type: application/json",
      "anthropic-version: 2023-06-01",
      "x-api-key: " . $apiKey
    ]);
    $result = curl_exec($ch);
    curl_close($ch);
    $output = json_decode($result, true);

    // 回答を出力
    // echo $output['content'][0]['text'];
    \Log::debug($output);
    return $output['content'][0]['text'];
  }
}
