<?php

namespace Ugarit\Artifacts\Geography\Http\Controllers\Country\Capabilities;

use Heritage\Http\Request;
use Heritage\Routing\Controller;
use Ugarit\Artifacts\Geography\Capabilities\Country\CreateCountryCapability;
use Ugarit\Artifacts\Geography\Capabilities\Country\DestroyCountryCapability;
use Ugarit\Artifacts\Geography\Capabilities\Country\EditCountryCapability;
use Ugarit\Artifacts\Geography\Capabilities\Country\IndexCountriesCapability;
use Ugarit\Artifacts\Geography\Capabilities\Country\SaveCountryCapability;
use Ugarit\Artifacts\Geography\Capabilities\Country\ShowCountryCapability;
use Ugarit\Artifacts\Geography\Http\Requests\Country\Capabilities\DestroyCountryRequest;
use Ugarit\Artifacts\Geography\Http\Requests\Country\Capabilities\StoreCountryRequest;
use Ugarit\Artifacts\Geography\Http\Requests\Country\Capabilities\UpdateCountryRequest;
use Ugarit\Artifacts\Geography\Http\Resources\Country\CountryResource;
use Ugarit\Artifacts\Geography\Models\Country;
use Ugarit\Artifacts\Geography\Parcels\Country\Capabilities\DestroyCountryParcel;
use Ugarit\Artifacts\Geography\Parcels\Country\Capabilities\EditCountryParcel;
use Ugarit\Artifacts\Geography\Parcels\Country\Capabilities\IndexCountryParcel;
use Ugarit\Artifacts\Geography\Parcels\Country\Capabilities\SaveCountryParcel;
use Ugarit\Artifacts\Geography\Parcels\Country\Capabilities\ShowCountryParcel;

/**
 * Handles the HTTP endpoints of the Country capabilities.
 *
 * Every endpoint answers JSON to clients expecting JSON (ResponderType::AUTO).
 */
class CountryController extends Controller
{
    /**
     * List countries, filtered, searched, sorted and paged by the query string.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->page(IndexCountriesCapability::class, IndexCountryParcel::fromQuery($request->query()), 'geography::country/Index', CountryResource::class);
    }

    /**
     * Render the create country form.
     *
     * @return mixed
     */
    public function create()
    {
        return $this->page(CreateCountryCapability::class, null, 'geography::country/Create');
    }

    /**
     * Create a country.
     *
     * @param  StoreCountryRequest  $request  Validated creation payload.
     * @return mixed
     */
    public function store(StoreCountryRequest $request)
    {
        return $this->back(SaveCountryCapability::class, SaveCountryParcel::fromArray($request->validated()), CountryResource::class);
    }

    /**
     * Show a country.
     *
     * @param  Country  $country  Resolved via route-model binding.
     * @return mixed
     */
    public function show(Country $country)
    {
        return $this->page(ShowCountryCapability::class, ShowCountryParcel::fromModel($country, true), 'geography::country/Show', CountryResource::class);
    }

    /**
     * Render the edit form of a country.
     *
     * @param  Country  $country  Resolved via route-model binding.
     * @return mixed
     */
    public function edit(Country $country)
    {
        return $this->page(EditCountryCapability::class, EditCountryParcel::fromModel($country, true), 'geography::country/Edit', CountryResource::class);
    }

    /**
     * Update a country.
     *
     * @param  UpdateCountryRequest  $request  Validated update payload.
     * @param  Country  $country  Resolved via route-model binding.
     * @return mixed
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        return $this->back(SaveCountryCapability::class, SaveCountryParcel::fromArray($request->validated())->setModel($country), CountryResource::class);
    }

    /**
     * Delete a country, then go to the index (back when it fails).
     *
     * @param  DestroyCountryRequest  $request  Validated deletion payload.
     * @param  Country  $country  Resolved via route-model binding.
     * @return mixed
     */
    public function destroy(DestroyCountryRequest $request, Country $country)
    {
        return $this->toRoute(
            DestroyCountryCapability::class,
            DestroyCountryParcel::fromArray([...$request->validated(), 'id' => $country->id])->setModel($country),
            'country.index'
        );
    }
}
