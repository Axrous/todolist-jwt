<?php

namespace App\Providers;

use App\Services\Impl\TodoServiceImpl;
use App\Services\TodoService;
use Illuminate\Support\ServiceProvider;

class TodoServiceProvider extends ServiceProvider
{

    public $singletons = [TodoService::class => TodoServiceImpl::class];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TodoService::class, function() {
            return new TodoService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
