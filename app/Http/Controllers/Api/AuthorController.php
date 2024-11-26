<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $userId = Auth::id();
    $authors = Author::where('user_id', $userId)->get();
    // 画像のフルURLを生成
    foreach ($authors as $author) {
      if ($author->author_image) {
        $author->author_image = asset('storage/artist/' . $userId . '/' . $author->author_id . '/' . $author->author_image);
      }
    }
    return response()->json($authors);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(AuthorRequest $request)
  {
    // リクエストデータを取得
    $data = $request->except(['author_image']);
    // user_idを追加
    $data['user_id'] = Auth::id();
    // レコードを作成
    $newData = Author::create($data);
    // 画像ファイルがアップロードされているか確認
    if ($request->hasFile('author_image')) {
      $file = $request->file('author_image');
      $path = 'public/artist' . '/' . Auth::id() . '/' . $newData->author_id;
      // ファイルを保存し、パスを取得
      $filePath = $file->store($path);
      // ファイル名のみをレコードデータに追加
      $recordData['author_image'] = basename($filePath);
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
  public function update(Request $request, $id)
  {
    $author = Author::find($id)->update($request->all());
    return response()->json($author);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }

  /**
   * アーティスト一覧をリスト形式で取得
   */
  public function list()
  {
    $userId = Auth::id();
    $authors = Author::where('user_id', $userId)->pluck('author_name', 'author_id');
    return response()->json($authors);
  }
}
