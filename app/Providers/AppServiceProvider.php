<?php

namespace App\Providers;

use App\Repositories\AuthorRepositoryInterface;
use App\Repositories\Implements\AuthorRepository;
use App\Repositories\Implements\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepositoryInterface;

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
    $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
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
