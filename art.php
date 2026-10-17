<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography;

use Heritage\Support\Artifact;

/**
 * Artifact manifest for the Geography domain artifact.
 *
 * This file defines the identity, capabilities, providers, and dependencies
 * for the geography artifact within the Ugarit ecosystem.
 */
return new class extends Artifact
{
    /**
     * The unique slug identifier for this artifact.
     *
     * @var string
     */
    public string $id = 'geography';

    /**
     * The human-readable display name of this artifact.
     *
     * @var string
     */
    public string $name = 'Geography Domain';

    /**
     * The semantic version of this artifact following Ugarit versioning (1.00.00).
     *
     * @var string
     */
    public string $version = '1.04.00';

    /**
     * Human-readable description of what this artifact provides.
     *
     * @var string
     */
    public string $description = 'ISO countries, governorates/states, cities, districts, addresses and geospatial coordinates';

    /**
     * Technical capabilities exposed by this artifact to other artifacts.
     *
     * Keys are capability slugs, values describe what the capability provides.
     *
     * @var array<string, string>
     */
    public array $capabilities = [
        'countries' => 'ISO-3166 countries, capitals, currencies, dialing codes, and flags',
        'governorates' => 'First-level administrative divisions, provinces, and states',
        'cities' => 'Cities, municipalities, and localized urban regions',
        'districts' => 'Districts, neighborhoods, and municipal subdivisions',
        'locations' => 'Geospatial coordinates, latitude/longitude, and addresses',
    ];

    /**
     * Service providers that should be registered when this artifact is loaded.
     *
     * @var array<int, class-string<\Heritage\Support\ServiceProvider>>
     */
    public array $providers = [
        Providers\GeographyServiceProvider::class,
    ];

    /**
     * Capability slugs required from other artifacts before this one can boot.
     *
     * @var array<int, string>
     */
    public array $requires = [
        'i18n.translations',
    ];

    /**
     * Perform any bootstrap logic specific to this artifact.
     *
     * Called after all providers have been registered and booted.
     *
     * @return void
     */
    public function boot(): void
    {
        // Internal geography artifact bootstrap logic
    }
};
