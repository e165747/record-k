<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Services\AuthorService;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
  protected $authorService;

  public function __construct(AuthorService $authorService)
  {
    $this->authorService = $authorService;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return response()->json($this->authorService->index());
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
    $file = $request->file('author_image');
    return response()->json($this->authorService->store($data, $file));
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
    $date = $request->all();
    return response()->json($this->authorService->update($date, $id));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $this->authorService->destroy($id);
    return response()->json(['message' => '削除しました']);
  }

  /**
   * アーティスト一覧をリスト形式で取得
   */
  public function list()
  {
    return response()->json($this->authorService->getList());
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
    $file = $request->file('author_img');
    return response()->json($this->authorService->upsertImage($requestData, $file, $id));
  }
}
