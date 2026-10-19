<?php

namespace Ugarit\Artifacts\Geography\Http\Controllers\Governorate\Capabilities;

use Heritage\Http\Request;
use Heritage\Routing\Controller;
use Ugarit\Artifacts\Geography\Capabilities\Governorate\CreateGovernorateCapability;
use Ugarit\Artifacts\Geography\Capabilities\Governorate\DestroyGovernorateCapability;
use Ugarit\Artifacts\Geography\Capabilities\Governorate\EditGovernorateCapability;
use Ugarit\Artifacts\Geography\Capabilities\Governorate\IndexGovernoratesCapability;
use Ugarit\Artifacts\Geography\Capabilities\Governorate\SaveGovernorateCapability;
use Ugarit\Artifacts\Geography\Capabilities\Governorate\ShowGovernorateCapability;
use Ugarit\Artifacts\Geography\Http\Requests\Governorate\Capabilities\DestroyGovernorateRequest;
use Ugarit\Artifacts\Geography\Http\Requests\Governorate\Capabilities\StoreGovernorateRequest;
use Ugarit\Artifacts\Geography\Http\Requests\Governorate\Capabilities\UpdateGovernorateRequest;
use Ugarit\Artifacts\Geography\Http\Resources\Governorate\GovernorateResource;
use Ugarit\Artifacts\Geography\Models\Governorate;
use Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities\DestroyGovernorateParcel;
use Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities\EditGovernorateParcel;
use Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities\IndexGovernorateParcel;
use Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities\SaveGovernorateParcel;
use Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities\ShowGovernorateParcel;

/**
 * Handles the HTTP endpoints of the Governorate capabilities.
 *
 * Every endpoint answers JSON to clients expecting JSON (ResponderType::AUTO).
 */
class GovernorateController extends Controller
{
    /**
     * List governorates, filtered, searched, sorted and paged by the query string.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->page(IndexGovernoratesCapability::class, IndexGovernorateParcel::fromQuery($request->query()), 'geography::governorate/Index', GovernorateResource::class);
    }

    /**
     * Render the create governorate form.
     *
     * @return mixed
     */
    public function create()
    {
        return $this->page(CreateGovernorateCapability::class, null, 'geography::governorate/Create');
    }

    /**
     * Create a governorate.
     *
     * @param  StoreGovernorateRequest  $request  Validated creation payload.
     * @return mixed
     */
    public function store(StoreGovernorateRequest $request)
    {
        return $this->back(SaveGovernorateCapability::class, SaveGovernorateParcel::fromArray($request->validated()), GovernorateResource::class);
    }

    /**
     * Show a governorate.
     *
     * @param  Governorate  $governorate  Resolved via route-model binding.
     * @return mixed
     */
    public function show(Governorate $governorate)
    {
        return $this->page(ShowGovernorateCapability::class, ShowGovernorateParcel::fromModel($governorate, true), 'geography::governorate/Show', GovernorateResource::class);
    }

    /**
     * Render the edit form of a governorate.
     *
     * @param  Governorate  $governorate  Resolved via route-model binding.
     * @return mixed
     */
    public function edit(Governorate $governorate)
    {
        return $this->page(EditGovernorateCapability::class, EditGovernorateParcel::fromModel($governorate, true), 'geography::governorate/Edit', GovernorateResource::class);
    }

    /**
     * Update a governorate.
     *
     * @param  UpdateGovernorateRequest  $request  Validated update payload.
     * @param  Governorate  $governorate  Resolved via route-model binding.
     * @return mixed
     */
    public function update(UpdateGovernorateRequest $request, Governorate $governorate)
    {
        return $this->back(SaveGovernorateCapability::class, SaveGovernorateParcel::fromArray($request->validated())->setModel($governorate), GovernorateResource::class);
    }

    /**
     * Delete a governorate, then go to the index (back when it fails).
     *
     * @param  DestroyGovernorateRequest  $request  Validated deletion payload.
     * @param  Governorate  $governorate  Resolved via route-model binding.
     * @return mixed
     */
    public function destroy(DestroyGovernorateRequest $request, Governorate $governorate)
    {
        return $this->toRoute(
            DestroyGovernorateCapability::class,
            DestroyGovernorateParcel::fromArray([...$request->validated(), 'id' => $governorate->id])->setModel($governorate),
            'governorate.index'
        );
    }
}
