<?php

namespace App\Providers;

use App\Models\Tools\UsageTablesBuilder;
use CloudCreativity\LaravelJsonApi\LaravelJsonApi;
use Illuminate\Database\Eloquent\Builder;
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
        LaravelJsonApi::showValidatorFailures();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        LaravelJsonApi::defaultApi('v1');
        Builder::mixin(new UsageTablesBuilder);
    }
}
