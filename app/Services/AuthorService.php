<?php

namespace App\Services;

use App\Repositories\AuthorRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthorService
{
  protected $authorRepository;

  public function __construct(AuthorRepositoryInterface $authorRepository)
  {
    $this->authorRepository = $authorRepository;
  }

  public function index()
  {
    return $this->authorRepository->index();
  }

  public function store(array $data, $file = null)
  {
    // user_idを追加
    $data['user_id'] = Auth::id();
    // レコードを作成
    $newData = $this->authorRepository->store($data);

    // 画像ファイルがアップロードされているか確認
    if ($file) {
      $path = $this->getFilePath($newData->author_id, Auth::id());
      // ファイルを保存し、パスを取得
      $filePath = $file->store($path);
      // ファイル名のみをレコードデータに追加
      $recordData['author_image'] = basename($filePath);
      $this->authorRepository->update($recordData, $newData->author_id);
    }

    return $newData;
  }

  /**
   * データ更新
   */
  public function update(array $data, $id)
  {
    return $this->authorRepository->update($data, $id);
  }

  /**
   * データ削除
   */
  public function destroy($id)
  {
    $this->authorRepository->destroy($id);
  }

  /**
   * アーティスト一覧をリスト形式で取得
   */
  public function getList()
  {
    return $this->authorRepository->getList();
  }

  /**
   * レコードの画像を保存または更新
   * 
   * @param array $data
   * @param int $id
   * 
   * @return \Illuminate\Http\Response
   */
  public function upsertImage(array $data, $file = null, $id)
  {
    // 画像ファイルがアップロードされているか確認
    if ($file) {
      $path = $this->getFilePath($id, Auth::id());
      // ファイルを保存し、パスを取得
      $filePath = $file->store($path);
      // ファイル名のみをレコードデータに追加
      $data['author_image'] = basename($filePath);
    }
    // 以前の画像ファイル名を取得
    $prevImage = $this->authorRepository->getById($id)->author_image;
    // アーティストを更新
    $newData = $this->authorRepository->update($data, $id);

    if ($prevImage && $prevImage !== $newData->author_image) {
      $imagePath = 'public/artist/' . Auth::id() . '/' . $id . '/' . $prevImage;
      // 画像ファイルが存在する場合は削除
      if (Storage::exists($imagePath)) {
        Storage::delete($imagePath);
      }
    }
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
}
