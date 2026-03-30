<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PrefixedIdManager;

class PrefixedIdServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PrefixedIdManager::class, fn() => new PrefixedIdManager());
    }

    public function boot()
    {
        app(PrefixedIdManager::class)
            ->registerModels(config('prefixed_ids.models'));
    }
}