<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecordRequest;
use App\Models\Record;
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
    $record = $request->all();
    // レコードを作成
    Record::create($record);
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
    $record = $request->all();
    // レコードを更新
    Record::find($id)->update($record);
    return response()->json(['message' => 'Updated successfully']);
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
}
