<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Http\Controllers\City\Features;

use Heritage\Routing\Controller;
use Ugarit\Artifacts\Geography\Features\City\SaveCityFeature;
use Ugarit\Artifacts\Geography\Http\Requests\City\Features\StoreCityRequest;
use Ugarit\Artifacts\Geography\Http\Requests\City\Features\UpdateCityRequest;
use Ugarit\Artifacts\Geography\Http\Resources\City\CityResource;
use Ugarit\Artifacts\Geography\Models\City;
use Ugarit\Artifacts\Geography\Parcels\City\Features\SaveCityParcel;

/**
 * Handles the HTTP endpoints of the City features: saving a city with its translations.
 */
class CityController extends Controller
{
    /**
     * Create a city with its translations.
     *
     * @param  StoreCityRequest  $request  Validated creation payload.
     * @return mixed
     */
    public function store(StoreCityRequest $request)
    {
        return $this->back(SaveCityFeature::class, SaveCityParcel::fromArray($request->validated()), CityResource::class);
    }

    /**
     * Update a city and its translations.
     *
     * @param  UpdateCityRequest  $request  Validated update payload.
     * @param  City  $city  Resolved via route-model binding.
     * @return mixed
     */
    public function update(UpdateCityRequest $request, City $city)
    {
        return $this->back(SaveCityFeature::class, SaveCityParcel::fromArray($request->validated())->setModel($city), CityResource::class);
    }
}
