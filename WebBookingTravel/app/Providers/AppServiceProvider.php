<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Chia sẻ danh sách category cho mọi view (dùng cache đơn giản tránh query lặp lại)
        View::composer('*', function ($view) {
            static $sharedCategories = null;
            if ($sharedCategories === null) {
                $sharedCategories = Category::orderBy('categoryName')->get(['categoryID', 'categoryName']);
            }
            $view->with('sharedCategories', $sharedCategories);
        });
    }
}
