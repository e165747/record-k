<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

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
    $cacheKey = 'authors_' . $userId;
    $authors = Cache::remember($cacheKey, 60 * 60, function () use ($userId) {
      $authors = Author::where('user_id', $userId)->get();
      // 画像のフルURLを生成
      foreach ($authors as $author) {
        if ($author->author_image) {
          $author->author_image = asset('storage/artist/' . $userId . '/' . $author->author_id . '/' . $author->author_image);
        }
      }
      return $authors;
    });
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
      $path = $this->getFilePath($newData->author_id, Auth::id());
      // ファイルを保存し、パスを取得
      $filePath = $file->store($path);
      // ファイル名のみをレコードデータに追加
      $recordData['author_image'] = basename($filePath);
      $newData->update($recordData);
    }
    $this->forgetCache();
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
    $this->forgetCache();
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
    $author = Author::find($id);
    $imagePath = 'public/artist/' . Auth::id() . '/' . $id . '/' . $author->author_image;
    $author->delete();
    // 画像ファイルが存在する場合は削除
    if ($author->author_image && Storage::exists($imagePath)) {
      Storage::delete($imagePath);
    }
    // アーティストに紐づくレコードも削除
    Record::where('author_id', $id)->delete();
    $this->forgetCache();
    return response()->json($author);
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
    $requestData = $request->all();
    // 画像ファイルがアップロードされているか確認
    if ($request->hasFile('author_img')) {
      $file = $request->file('author_img');
      $path = $this->getFilePath($id, Auth::id());
      // ファイルを保存し、パスを取得
      $filePath = $file->store($path);
      // ファイル名のみをレコードデータに追加
      $requestData['author_image'] = basename($filePath);
    }
    // アーティストを更新
    $data = Author::find($id);
    $prevImage = $data->author_image;
    $data->author_image = $requestData['author_image'];
    $data->save();

    if ($prevImage && $prevImage !== $data->author_image) {
      $imagePath = 'public/artist/' . Auth::id() . '/' . $id . '/' . $prevImage;
      // 画像ファイルが存在する場合は削除
      if (Storage::exists($imagePath)) {
        Storage::delete($imagePath);
      }
    }
    $this->forgetCache();
    return response()->json($data);
  }

  /**
   * ファイルパスを取得する
   * 
   * @param int $id
   * @param int $userId
   */
  private function getFilePath($id, $userId)
  {
    return 'public/artist' . '/' . $userId . '/' . $id;
  }

  /**
   * キャッシュを削除する内部メソッド　
   * 
   * @return void
   */
  private function forgetCache()
  {
    $userId = Auth::id();
    $cacheKey = 'authors_' . $userId;
    if (Cache::has($cacheKey)) {
      Cache::forget($cacheKey);
    }
  }
}
