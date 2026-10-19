<?php

namespace Ugarit\Artifacts\Geography\Http\Controllers\District\Capabilities;

use Heritage\Http\Request;
use Heritage\Routing\Controller;
use Ugarit\Artifacts\Geography\Capabilities\District\CreateDistrictCapability;
use Ugarit\Artifacts\Geography\Capabilities\District\DestroyDistrictCapability;
use Ugarit\Artifacts\Geography\Capabilities\District\EditDistrictCapability;
use Ugarit\Artifacts\Geography\Capabilities\District\IndexDistrictsCapability;
use Ugarit\Artifacts\Geography\Capabilities\District\SaveDistrictCapability;
use Ugarit\Artifacts\Geography\Capabilities\District\ShowDistrictCapability;
use Ugarit\Artifacts\Geography\Http\Requests\District\Capabilities\DestroyDistrictRequest;
use Ugarit\Artifacts\Geography\Http\Requests\District\Capabilities\StoreDistrictRequest;
use Ugarit\Artifacts\Geography\Http\Requests\District\Capabilities\UpdateDistrictRequest;
use Ugarit\Artifacts\Geography\Http\Resources\District\DistrictResource;
use Ugarit\Artifacts\Geography\Models\District;
use Ugarit\Artifacts\Geography\Parcels\District\Capabilities\DestroyDistrictParcel;
use Ugarit\Artifacts\Geography\Parcels\District\Capabilities\EditDistrictParcel;
use Ugarit\Artifacts\Geography\Parcels\District\Capabilities\IndexDistrictParcel;
use Ugarit\Artifacts\Geography\Parcels\District\Capabilities\SaveDistrictParcel;
use Ugarit\Artifacts\Geography\Parcels\District\Capabilities\ShowDistrictParcel;

/**
 * Handles the HTTP endpoints of the District capabilities.
 *
 * Every endpoint answers JSON to clients expecting JSON (ResponderType::AUTO).
 */
class DistrictController extends Controller
{
    /**
     * List districts, filtered, searched, sorted and paged by the query string.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->page(IndexDistrictsCapability::class, IndexDistrictParcel::fromQuery($request->query()), 'geography::district/Index', DistrictResource::class);
    }

    /**
     * Render the create district form.
     *
     * @return mixed
     */
    public function create()
    {
        return $this->page(CreateDistrictCapability::class, null, 'geography::district/Create');
    }

    /**
     * Create a district.
     *
     * @param  StoreDistrictRequest  $request  Validated creation payload.
     * @return mixed
     */
    public function store(StoreDistrictRequest $request)
    {
        return $this->back(SaveDistrictCapability::class, SaveDistrictParcel::fromArray($request->validated()), DistrictResource::class);
    }

    /**
     * Show a district.
     *
     * @param  District  $district  Resolved via route-model binding.
     * @return mixed
     */
    public function show(District $district)
    {
        return $this->page(ShowDistrictCapability::class, ShowDistrictParcel::fromModel($district, true), 'geography::district/Show', DistrictResource::class);
    }

    /**
     * Render the edit form of a district.
     *
     * @param  District  $district  Resolved via route-model binding.
     * @return mixed
     */
    public function edit(District $district)
    {
        return $this->page(EditDistrictCapability::class, EditDistrictParcel::fromModel($district, true), 'geography::district/Edit', DistrictResource::class);
    }

    /**
     * Update a district.
     *
     * @param  UpdateDistrictRequest  $request  Validated update payload.
     * @param  District  $district  Resolved via route-model binding.
     * @return mixed
     */
    public function update(UpdateDistrictRequest $request, District $district)
    {
        return $this->back(SaveDistrictCapability::class, SaveDistrictParcel::fromArray($request->validated())->setModel($district), DistrictResource::class);
    }

    /**
     * Delete a district, then go to the index (back when it fails).
     *
     * @param  DestroyDistrictRequest  $request  Validated deletion payload.
     * @param  District  $district  Resolved via route-model binding.
     * @return mixed
     */
    public function destroy(DestroyDistrictRequest $request, District $district)
    {
        return $this->toRoute(
            DestroyDistrictCapability::class,
            DestroyDistrictParcel::fromArray([...$request->validated(), 'id' => $district->id])->setModel($district),
            'district.index'
        );
    }
}
