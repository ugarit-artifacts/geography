<?php

namespace Ugarit\Artifacts\Geography\Http\Controllers\City\Capabilities;

use Heritage\Http\Request;
use Heritage\Routing\Controller;
use Ugarit\Artifacts\Geography\Capabilities\City\CreateCityCapability;
use Ugarit\Artifacts\Geography\Capabilities\City\DestroyCityCapability;
use Ugarit\Artifacts\Geography\Capabilities\City\EditCityCapability;
use Ugarit\Artifacts\Geography\Capabilities\City\IndexCitiesCapability;
use Ugarit\Artifacts\Geography\Capabilities\City\SaveCityCapability;
use Ugarit\Artifacts\Geography\Capabilities\City\ShowCityCapability;
use Ugarit\Artifacts\Geography\Http\Requests\City\Capabilities\DestroyCityRequest;
use Ugarit\Artifacts\Geography\Http\Requests\City\Capabilities\StoreCityRequest;
use Ugarit\Artifacts\Geography\Http\Requests\City\Capabilities\UpdateCityRequest;
use Ugarit\Artifacts\Geography\Http\Resources\City\CityResource;
use Ugarit\Artifacts\Geography\Models\City;
use Ugarit\Artifacts\Geography\Parcels\City\Capabilities\DestroyCityParcel;
use Ugarit\Artifacts\Geography\Parcels\City\Capabilities\EditCityParcel;
use Ugarit\Artifacts\Geography\Parcels\City\Capabilities\IndexCityParcel;
use Ugarit\Artifacts\Geography\Parcels\City\Capabilities\SaveCityParcel;
use Ugarit\Artifacts\Geography\Parcels\City\Capabilities\ShowCityParcel;

/**
 * Handles the HTTP endpoints of the City capabilities.
 *
 * Every endpoint answers JSON to clients expecting JSON (ResponderType::AUTO).
 */
class CityController extends Controller
{
    /**
     * List cities, filtered, searched, sorted and paged by the query string.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->page(IndexCitiesCapability::class, IndexCityParcel::fromQuery($request->query()), 'geography::city/Index', CityResource::class);
    }

    /**
     * Render the create city form.
     *
     * @return mixed
     */
    public function create()
    {
        return $this->page(CreateCityCapability::class, null, 'geography::city/Create');
    }

    /**
     * Create a city.
     *
     * @param  StoreCityRequest  $request  Validated creation payload.
     * @return mixed
     */
    public function store(StoreCityRequest $request)
    {
        return $this->back(SaveCityCapability::class, SaveCityParcel::fromArray($request->validated()), CityResource::class);
    }

    /**
     * Show a city.
     *
     * @param  City  $city  Resolved via route-model binding.
     * @return mixed
     */
    public function show(City $city)
    {
        return $this->page(ShowCityCapability::class, ShowCityParcel::fromModel($city, true), 'geography::city/Show', CityResource::class);
    }

    /**
     * Render the edit form of a city.
     *
     * @param  City  $city  Resolved via route-model binding.
     * @return mixed
     */
    public function edit(City $city)
    {
        return $this->page(EditCityCapability::class, EditCityParcel::fromModel($city, true), 'geography::city/Edit', CityResource::class);
    }

    /**
     * Update a city.
     *
     * @param  UpdateCityRequest  $request  Validated update payload.
     * @param  City  $city  Resolved via route-model binding.
     * @return mixed
     */
    public function update(UpdateCityRequest $request, City $city)
    {
        return $this->back(SaveCityCapability::class, SaveCityParcel::fromArray($request->validated())->setModel($city), CityResource::class);
    }

    /**
     * Delete a city, then go to the index (back when it fails).
     *
     * @param  DestroyCityRequest  $request  Validated deletion payload.
     * @param  City  $city  Resolved via route-model binding.
     * @return mixed
     */
    public function destroy(DestroyCityRequest $request, City $city)
    {
        return $this->toRoute(
            DestroyCityCapability::class,
            DestroyCityParcel::fromArray([...$request->validated(), 'id' => $city->id])->setModel($city),
            'city.index'
        );
    }
}
