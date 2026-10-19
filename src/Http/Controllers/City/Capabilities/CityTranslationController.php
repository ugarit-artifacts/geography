<?php

namespace Ugarit\Artifacts\Geography\Http\Controllers\City\Capabilities;

use Heritage\Database\Eloquent\RuntimeTranslation;
use Heritage\Routing\Controller;
use Ugarit\Artifacts\Geography\Capabilities\City\Translation\DestroyCityTranslationCapability;
use Ugarit\Artifacts\Geography\Capabilities\City\Translation\SaveCityTranslationCapability;
use Ugarit\Artifacts\Geography\Http\Requests\City\Capabilities\Translation\DestroyCityTranslationRequest;
use Ugarit\Artifacts\Geography\Http\Requests\City\Capabilities\Translation\StoreCityTranslationRequest;
use Ugarit\Artifacts\Geography\Http\Requests\City\Capabilities\Translation\UpdateCityTranslationRequest;
use Ugarit\Artifacts\Geography\Http\Resources\City\Translation\CityTranslationResource;
use Ugarit\Artifacts\Geography\Models\City;
use Ugarit\Artifacts\Geography\Parcels\City\Capabilities\Translation\DestroyCityTranslationParcel;
use Ugarit\Artifacts\Geography\Parcels\City\Capabilities\Translation\SaveCityTranslationParcel;

/**
 * Handles the HTTP endpoints of the City translations, nested under their city.
 */
class CityTranslationController extends Controller
{
    /**
     * Create the translation of a city for one locale.
     *
     * @param  StoreCityTranslationRequest  $request  Validated creation payload.
     * @param  City  $city  Resolved via route-model binding.
     * @return mixed
     */
    public function store(StoreCityTranslationRequest $request, City $city)
    {
        return $this->back(
            SaveCityTranslationCapability::class,
            SaveCityTranslationParcel::fromArray([...$request->validated(), 'city_id' => $city->id]),
            CityTranslationResource::class,
        );
    }

    /**
     * Update a translation of a city.
     *
     * @param  UpdateCityTranslationRequest  $request  Validated update payload.
     * @param  City  $city  Resolved via route-model binding.
     * @param  RuntimeTranslation  $cityTranslation  Resolved through the city (404 for another city's).
     * @return mixed
     */
    public function update(UpdateCityTranslationRequest $request, City $city, RuntimeTranslation $cityTranslation)
    {
        return $this->back(
            SaveCityTranslationCapability::class,
            SaveCityTranslationParcel::fromArray($request->validated())->setModel($cityTranslation),
            CityTranslationResource::class,
        );
    }

    /**
     * Delete a translation of a city.
     *
     * @param  DestroyCityTranslationRequest  $request  Validated deletion payload.
     * @param  City  $city  Resolved via route-model binding.
     * @param  RuntimeTranslation  $cityTranslation  Resolved through the city (404 for another city's).
     * @return mixed
     */
    public function destroy(DestroyCityTranslationRequest $request, City $city, RuntimeTranslation $cityTranslation)
    {
        return $this->back(
            DestroyCityTranslationCapability::class,
            DestroyCityTranslationParcel::fromArray(['city_id' => $city->id])->setModel($cityTranslation),
        );
    }
}
