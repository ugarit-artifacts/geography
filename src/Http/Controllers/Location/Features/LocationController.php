<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Http\Controllers\Location\Features;

use Heritage\Routing\Controller;
use Ugarit\Artifacts\Geography\Features\Location\SaveLocationFeature;
use Ugarit\Artifacts\Geography\Http\Requests\Location\Features\StoreLocationRequest;
use Ugarit\Artifacts\Geography\Http\Requests\Location\Features\UpdateLocationRequest;
use Ugarit\Artifacts\Geography\Http\Resources\Location\LocationResource;
use Ugarit\Artifacts\Geography\Models\Location;
use Ugarit\Artifacts\Geography\Parcels\Location\Features\SaveLocationParcel;

/**
 * Handles the HTTP endpoints of the Location features: saving a location with its translations.
 */
class LocationController extends Controller
{
    /**
     * Create a location with its translations.
     *
     * @param  StoreLocationRequest  $request  Validated creation payload.
     * @return mixed
     */
    public function store(StoreLocationRequest $request)
    {
        return $this->back(SaveLocationFeature::class, SaveLocationParcel::fromArray($request->validated()), LocationResource::class);
    }

    /**
     * Update a location and its translations.
     *
     * @param  UpdateLocationRequest  $request  Validated update payload.
     * @param  Location  $location  Resolved via route-model binding.
     * @return mixed
     */
    public function update(UpdateLocationRequest $request, Location $location)
    {
        return $this->back(SaveLocationFeature::class, SaveLocationParcel::fromArray($request->validated())->setModel($location), LocationResource::class);
    }
}
