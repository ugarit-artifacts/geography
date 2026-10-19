<?php

namespace Ugarit\Artifacts\Geography\Http\Controllers\Location\Capabilities;

use Heritage\Http\Request;
use Heritage\Routing\Controller;
use Ugarit\Artifacts\Geography\Capabilities\Location\CreateLocationCapability;
use Ugarit\Artifacts\Geography\Capabilities\Location\DestroyLocationCapability;
use Ugarit\Artifacts\Geography\Capabilities\Location\EditLocationCapability;
use Ugarit\Artifacts\Geography\Capabilities\Location\IndexLocationsCapability;
use Ugarit\Artifacts\Geography\Capabilities\Location\SaveLocationCapability;
use Ugarit\Artifacts\Geography\Capabilities\Location\ShowLocationCapability;
use Ugarit\Artifacts\Geography\Http\Requests\Location\Capabilities\DestroyLocationRequest;
use Ugarit\Artifacts\Geography\Http\Requests\Location\Capabilities\StoreLocationRequest;
use Ugarit\Artifacts\Geography\Http\Requests\Location\Capabilities\UpdateLocationRequest;
use Ugarit\Artifacts\Geography\Http\Resources\Location\LocationResource;
use Ugarit\Artifacts\Geography\Models\Location;
use Ugarit\Artifacts\Geography\Parcels\Location\Capabilities\DestroyLocationParcel;
use Ugarit\Artifacts\Geography\Parcels\Location\Capabilities\EditLocationParcel;
use Ugarit\Artifacts\Geography\Parcels\Location\Capabilities\IndexLocationParcel;
use Ugarit\Artifacts\Geography\Parcels\Location\Capabilities\SaveLocationParcel;
use Ugarit\Artifacts\Geography\Parcels\Location\Capabilities\ShowLocationParcel;

/**
 * Handles the HTTP endpoints of the Location capabilities.
 *
 * Every endpoint answers JSON to clients expecting JSON (ResponderType::AUTO).
 */
class LocationController extends Controller
{
    /**
     * List locations, filtered, searched, sorted and paged by the query string.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->page(IndexLocationsCapability::class, IndexLocationParcel::fromQuery($request->query()), 'geography::location/Index', LocationResource::class);
    }

    /**
     * Render the create location form.
     *
     * @return mixed
     */
    public function create()
    {
        return $this->page(CreateLocationCapability::class, null, 'geography::location/Create');
    }

    /**
     * Create a location.
     *
     * @param  StoreLocationRequest  $request  Validated creation payload.
     * @return mixed
     */
    public function store(StoreLocationRequest $request)
    {
        return $this->back(SaveLocationCapability::class, SaveLocationParcel::fromArray($request->validated()), LocationResource::class);
    }

    /**
     * Show a location.
     *
     * @param  Location  $location  Resolved via route-model binding.
     * @return mixed
     */
    public function show(Location $location)
    {
        return $this->page(ShowLocationCapability::class, ShowLocationParcel::fromModel($location, true), 'geography::location/Show', LocationResource::class);
    }

    /**
     * Render the edit form of a location.
     *
     * @param  Location  $location  Resolved via route-model binding.
     * @return mixed
     */
    public function edit(Location $location)
    {
        return $this->page(EditLocationCapability::class, EditLocationParcel::fromModel($location, true), 'geography::location/Edit', LocationResource::class);
    }

    /**
     * Update a location.
     *
     * @param  UpdateLocationRequest  $request  Validated update payload.
     * @param  Location  $location  Resolved via route-model binding.
     * @return mixed
     */
    public function update(UpdateLocationRequest $request, Location $location)
    {
        return $this->back(SaveLocationCapability::class, SaveLocationParcel::fromArray($request->validated())->setModel($location), LocationResource::class);
    }

    /**
     * Delete a location, then go to the index (back when it fails).
     *
     * @param  DestroyLocationRequest  $request  Validated deletion payload.
     * @param  Location  $location  Resolved via route-model binding.
     * @return mixed
     */
    public function destroy(DestroyLocationRequest $request, Location $location)
    {
        return $this->toRoute(
            DestroyLocationCapability::class,
            DestroyLocationParcel::fromArray([...$request->validated(), 'id' => $location->id])->setModel($location),
            'location.index'
        );
    }
}
