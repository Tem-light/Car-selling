<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Load Database\Seeders and Database\Factories when Composer autoload misses them
        $base = base_path('database');
        foreach (['seeders', 'factories'] as $dir) {
            $path = $base . DIRECTORY_SEPARATOR . $dir;
            if (! is_dir($path)) {
                continue;
            }
            foreach (glob($path . DIRECTORY_SEPARATOR . '*.php') ?: [] as $file) {
                require_once $file;
            }
        }
        $this->app->bind('DatabaseSeeder', \Database\Seeders\DatabaseSeeder::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('pagination');
        View::share('year', date('Y'));

        View::composer('Layouts.app', function ($view) {
            $notificationUnreadCount = 0;
            if (auth()->check()) {
                $notificationUnreadCount = auth()->user()->notifications()->whereNull('read_at')->count();
            }
            $view->with('notificationUnreadCount', $notificationUnreadCount);
        });
    }
}
