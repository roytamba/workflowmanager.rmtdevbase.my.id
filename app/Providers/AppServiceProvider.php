<?php

namespace App\Providers;

use App\Http\Controllers\BreadcrumbController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
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
    public function boot(Request $request): void
    {
        View::composer('*', function ($view) use ($request) {
            $breadcrumbController = new BreadcrumbController();
            $breadcrumbs = $breadcrumbController->getBreadcrumbs($request);

            $view->with('breadcrumbs', $breadcrumbs);
        });
    }
}
