<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\SiteSetting;
use Illuminate\Support\ServiceProvider;

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
        $settings = SiteSetting::pluck('data','name')->toArray();

        $categories = Category::where('status','1')->with('subCategory')->withCount('items')->get();

        view()->share(['settings'=>$settings, 'categories'=>$categories]);
    }
}
