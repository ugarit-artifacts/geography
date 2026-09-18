<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Providers;

use Heritage\Support\ServiceProvider;
use Ugarit\Artifacts\Geography\Contracts\CityRepositoryContract;
use Ugarit\Artifacts\Geography\Contracts\CountryRepositoryContract;
use Ugarit\Artifacts\Geography\Contracts\GovernorateRepositoryContract;
use Ugarit\Artifacts\Geography\Contracts\LocationRepositoryContract;
use Ugarit\Artifacts\Geography\Repositories\CityRepository;
use Ugarit\Artifacts\Geography\Repositories\CountryRepository;
use Ugarit\Artifacts\Geography\Repositories\GovernorateRepository;
use Ugarit\Artifacts\Geography\Repositories\LocationRepository;

class GeographyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/geography.php', 'geography');

        $this->app->singleton(CountryRepositoryContract::class, CountryRepository::class);
        $this->app->singleton(GovernorateRepositoryContract::class, GovernorateRepository::class);
        $this->app->singleton(CityRepositoryContract::class, CityRepository::class);
        $this->app->singleton(LocationRepositoryContract::class, LocationRepository::class);
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

            $this->publishes([
                __DIR__ . '/../../config/geography.php' => config_path('geography.php'),
            ], 'geography-config');
        }
    }
}
