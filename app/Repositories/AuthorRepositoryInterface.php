<?php

namespace App\Repositories;

use App\Models\Author;
use Illuminate\Support\Collection;

interface AuthorRepositoryInterface
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index();

  /**
   * get author by id
   * 
   * @param int $id
   * 
   * @return App\Models\Author
   */
  public function getById(int $id): Author;

  /**
   * Store a newly created resource in storage.
   * 
   * @param array $data
   *
   * @return App\Models\Author
   */
  public function store($data): Author;
  /**
   * Display the specified resource.
   *
   * @param  array $data
   * @param  int  $id
   * @return App\Models\Author
   */
  public function update(array $data, int $author): Author;
  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $autohrId
   */
  public function destroy(int $authorId);
  /**
   * Display a listing of the resource.
   *
   * @return Collection
   */
  public function getList(): Collection;
}
