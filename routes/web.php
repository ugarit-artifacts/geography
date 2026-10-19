<?php

use Heritage\Support\Facades\Route;
use Ugarit\Artifacts\Geography\Http\Controllers\Country\Capabilities\CountryController as CountryCapabilitiesController;
use Ugarit\Artifacts\Geography\Http\Controllers\Country\Features\CountryController as CountryFeaturesController;
use Ugarit\Artifacts\Geography\Http\Controllers\Country\Capabilities\CountryTranslationController as CountryTranslationCapabilitiesController;
use Ugarit\Artifacts\Geography\Http\Controllers\Governorate\Capabilities\GovernorateController as GovernorateCapabilitiesController;
use Ugarit\Artifacts\Geography\Http\Controllers\Governorate\Features\GovernorateController as GovernorateFeaturesController;
use Ugarit\Artifacts\Geography\Http\Controllers\Governorate\Capabilities\GovernorateTranslationController as GovernorateTranslationCapabilitiesController;
use Ugarit\Artifacts\Geography\Http\Controllers\City\Capabilities\CityController as CityCapabilitiesController;
use Ugarit\Artifacts\Geography\Http\Controllers\City\Features\CityController as CityFeaturesController;
use Ugarit\Artifacts\Geography\Http\Controllers\City\Capabilities\CityTranslationController as CityTranslationCapabilitiesController;
use Ugarit\Artifacts\Geography\Http\Controllers\District\Capabilities\DistrictController as DistrictCapabilitiesController;
use Ugarit\Artifacts\Geography\Http\Controllers\District\Features\DistrictController as DistrictFeaturesController;
use Ugarit\Artifacts\Geography\Http\Controllers\District\Capabilities\DistrictTranslationController as DistrictTranslationCapabilitiesController;
use Ugarit\Artifacts\Geography\Http\Controllers\Location\Capabilities\LocationController as LocationCapabilitiesController;
use Ugarit\Artifacts\Geography\Http\Controllers\Location\Features\LocationController as LocationFeaturesController;
use Ugarit\Artifacts\Geography\Http\Controllers\Location\Capabilities\LocationTranslationController as LocationTranslationCapabilitiesController;
use Ugarit\Artifacts\Geography\Http\Controllers\Artifact\ArtifactController;

Route::middleware(['web', 'auth'])->prefix('panel/artifact/geography')->group(function () {
    Route::get('/', [ArtifactController::class, 'show'])->name('geography.artifact.show');

    Route::resource('country', CountryCapabilitiesController::class);

    Route::resource('country-feature', CountryFeaturesController::class)->only(['store', 'update'])->parameters(['country-feature' => 'country']);

    Route::resource('{country}/country-translation', CountryTranslationCapabilitiesController::class)->only(['store', 'update', 'destroy'])->scoped(['country_translation' => 'id']);

    Route::resource('governorate', GovernorateCapabilitiesController::class);

    Route::resource('governorate-feature', GovernorateFeaturesController::class)->only(['store', 'update'])->parameters(['governorate-feature' => 'governorate']);

    Route::resource('{governorate}/governorate-translation', GovernorateTranslationCapabilitiesController::class)->only(['store', 'update', 'destroy'])->scoped(['governorate_translation' => 'id']);

    Route::resource('city', CityCapabilitiesController::class);

    Route::resource('city-feature', CityFeaturesController::class)->only(['store', 'update'])->parameters(['city-feature' => 'city']);

    Route::resource('{city}/city-translation', CityTranslationCapabilitiesController::class)->only(['store', 'update', 'destroy'])->scoped(['city_translation' => 'id']);

    Route::resource('district', DistrictCapabilitiesController::class);

    Route::resource('district-feature', DistrictFeaturesController::class)->only(['store', 'update'])->parameters(['district-feature' => 'district']);

    Route::resource('{district}/district-translation', DistrictTranslationCapabilitiesController::class)->only(['store', 'update', 'destroy'])->scoped(['district_translation' => 'id']);

    Route::resource('location', LocationCapabilitiesController::class);

    Route::resource('location-feature', LocationFeaturesController::class)->only(['store', 'update'])->parameters(['location-feature' => 'location']);

    Route::resource('{location}/location-translation', LocationTranslationCapabilitiesController::class)->only(['store', 'update', 'destroy'])->scoped(['location_translation' => 'id']);
});
