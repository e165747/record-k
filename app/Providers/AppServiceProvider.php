<?php

namespace App\Providers;

use App\Repositories\AuthorRepositoryInterface;
use App\Repositories\Implements\AuthorRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind(AuthorRepositoryInterface::class, AuthorRepository::class);
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    //
  }
}
