<?php

namespace Ugarit\Artifacts\Geography\Http\Controllers\Country\Capabilities;

use Heritage\Database\Eloquent\RuntimeTranslation;
use Heritage\Routing\Controller;
use Ugarit\Artifacts\Geography\Capabilities\Country\Translation\DestroyCountryTranslationCapability;
use Ugarit\Artifacts\Geography\Capabilities\Country\Translation\SaveCountryTranslationCapability;
use Ugarit\Artifacts\Geography\Http\Requests\Country\Capabilities\Translation\DestroyCountryTranslationRequest;
use Ugarit\Artifacts\Geography\Http\Requests\Country\Capabilities\Translation\StoreCountryTranslationRequest;
use Ugarit\Artifacts\Geography\Http\Requests\Country\Capabilities\Translation\UpdateCountryTranslationRequest;
use Ugarit\Artifacts\Geography\Http\Resources\Country\Translation\CountryTranslationResource;
use Ugarit\Artifacts\Geography\Models\Country;
use Ugarit\Artifacts\Geography\Parcels\Country\Capabilities\Translation\DestroyCountryTranslationParcel;
use Ugarit\Artifacts\Geography\Parcels\Country\Capabilities\Translation\SaveCountryTranslationParcel;

/**
 * Handles the HTTP endpoints of the Country translations, nested under their country.
 */
class CountryTranslationController extends Controller
{
    /**
     * Create the translation of a country for one locale.
     *
     * @param  StoreCountryTranslationRequest  $request  Validated creation payload.
     * @param  Country  $country  Resolved via route-model binding.
     * @return mixed
     */
    public function store(StoreCountryTranslationRequest $request, Country $country)
    {
        return $this->back(
            SaveCountryTranslationCapability::class,
            SaveCountryTranslationParcel::fromArray([...$request->validated(), 'country_id' => $country->id]),
            CountryTranslationResource::class,
        );
    }

    /**
     * Update a translation of a country.
     *
     * @param  UpdateCountryTranslationRequest  $request  Validated update payload.
     * @param  Country  $country  Resolved via route-model binding.
     * @param  RuntimeTranslation  $countryTranslation  Resolved through the country (404 for another country's).
     * @return mixed
     */
    public function update(UpdateCountryTranslationRequest $request, Country $country, RuntimeTranslation $countryTranslation)
    {
        return $this->back(
            SaveCountryTranslationCapability::class,
            SaveCountryTranslationParcel::fromArray($request->validated())->setModel($countryTranslation),
            CountryTranslationResource::class,
        );
    }

    /**
     * Delete a translation of a country.
     *
     * @param  DestroyCountryTranslationRequest  $request  Validated deletion payload.
     * @param  Country  $country  Resolved via route-model binding.
     * @param  RuntimeTranslation  $countryTranslation  Resolved through the country (404 for another country's).
     * @return mixed
     */
    public function destroy(DestroyCountryTranslationRequest $request, Country $country, RuntimeTranslation $countryTranslation)
    {
        return $this->back(
            DestroyCountryTranslationCapability::class,
            DestroyCountryTranslationParcel::fromArray(['country_id' => $country->id])->setModel($countryTranslation),
        );
    }
}
