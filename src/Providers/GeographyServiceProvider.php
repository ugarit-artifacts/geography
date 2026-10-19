<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Providers;

use Heritage\Support\ServiceProvider;

/**
 * Class GeographyServiceProvider
 *
 * Service provider of the Geography artifact domain. The kernel loads the artifact's
 * resources by convention: its config files, migrations, translations (geography::file.key),
 * views (geography::view) and routes/web.php and routes/api.php.
 */
class GeographyServiceProvider extends ServiceProvider
{
    /**
     * Register geography domain services into the IoC container.
     *
     * Bind interfaces, singletons, or any service-level dependencies here.
     *
     * @return void
     */
    public function register(): void
    {
        // Geography service bindings
    }

    /**
     * Bootstrap geography domain services.
     *
     * This method is called after all providers have been registered.
     *
     * @return void
     */
    public function boot(): void
    {
        // Geography bootstrapping beyond the resources the kernel loads
    }
}
