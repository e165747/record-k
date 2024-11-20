<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecordRequest;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
  public function __construct()
  {
    $this->middleware('ensureUserOwnsRecord')->only(['show', 'update', 'destroy']);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // recordsテーブルのデータを全件取得
    $userId = Auth::id();
    $records = Record::where('user_id', $userId)->get();
    // 画像のフルURLを生成
    foreach ($records as $record) {
      if ($record->image_path) {
        $record->image_path = asset('storage/jacket/' . $userId . '/' . $record->record_id . '/' . $record->image_path);
      }
    }
    return response()->json($records);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(RecordRequest $request)
  {
    // リクエストデータを取得
    $recordData = $request->except(['jacket_img', 'image_path']);
    // レコードを作成
    $newData = Record::create($recordData);

    // 画像ファイルがアップロードされているか確認
    if ($request->hasFile('jacket_img')) {
      $file = $request->file('jacket_img');
      $path = 'public/jacket' . '/' . Auth::id() . '/' . $newData->id;
      // ファイルを保存し、パスを取得
      $filePath = $file->store($path);
      // ファイル名のみをレコードデータに追加
      $recordData['image_path'] = basename($filePath);
      $newData->update($recordData);
    }
    return response()->json($newData);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(RecordRequest $request, $id)
  {
    // リクエストデータを取得
    $recordData = $request->all();
    // レコードを更新
    $newData = Record::find($id)->update($recordData);

    return response()->json($newData);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    Record::destroy($id);
    return response()->json(['message' => 'Deleted successfully']);
  }

  /**
   * レコードの画像を保存または更新
   * 
   * @param Request $request
   * @param int $id
   * 
   * @return \Illuminate\Http\Response
   */
  public function upsertImage(Request $request, $id)
  {
    // リクエストデータを取得
    $recordData = $request->all();
    // 画像ファイルがアップロードされているか確認
    if ($request->hasFile('jacket_img')) {
      $file = $request->file('jacket_img');
      $path = 'public/jacket' . '/' . Auth::id() . '/' . $id;
      // ファイルを保存し、パスを取得
      $filePath = $file->store($path);
      // ファイル名のみをレコードデータに追加
      $recordData['image_path'] = basename($filePath);
    }
    // レコードを更新
    $newData = Record::find($id)->update($recordData);
    return response()->json($newData);
  }
}
