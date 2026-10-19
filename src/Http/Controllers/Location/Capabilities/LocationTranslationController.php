<?php

namespace Ugarit\Artifacts\Geography\Http\Controllers\Location\Capabilities;

use Heritage\Database\Eloquent\RuntimeTranslation;
use Heritage\Routing\Controller;
use Ugarit\Artifacts\Geography\Capabilities\Location\Translation\DestroyLocationTranslationCapability;
use Ugarit\Artifacts\Geography\Capabilities\Location\Translation\SaveLocationTranslationCapability;
use Ugarit\Artifacts\Geography\Http\Requests\Location\Capabilities\Translation\DestroyLocationTranslationRequest;
use Ugarit\Artifacts\Geography\Http\Requests\Location\Capabilities\Translation\StoreLocationTranslationRequest;
use Ugarit\Artifacts\Geography\Http\Requests\Location\Capabilities\Translation\UpdateLocationTranslationRequest;
use Ugarit\Artifacts\Geography\Http\Resources\Location\Translation\LocationTranslationResource;
use Ugarit\Artifacts\Geography\Models\Location;
use Ugarit\Artifacts\Geography\Parcels\Location\Capabilities\Translation\DestroyLocationTranslationParcel;
use Ugarit\Artifacts\Geography\Parcels\Location\Capabilities\Translation\SaveLocationTranslationParcel;

/**
 * Handles the HTTP endpoints of the Location translations, nested under their location.
 */
class LocationTranslationController extends Controller
{
    /**
     * Create the translation of a location for one locale.
     *
     * @param  StoreLocationTranslationRequest  $request  Validated creation payload.
     * @param  Location  $location  Resolved via route-model binding.
     * @return mixed
     */
    public function store(StoreLocationTranslationRequest $request, Location $location)
    {
        return $this->back(
            SaveLocationTranslationCapability::class,
            SaveLocationTranslationParcel::fromArray([...$request->validated(), 'location_id' => $location->id]),
            LocationTranslationResource::class,
        );
    }

    /**
     * Update a translation of a location.
     *
     * @param  UpdateLocationTranslationRequest  $request  Validated update payload.
     * @param  Location  $location  Resolved via route-model binding.
     * @param  RuntimeTranslation  $locationTranslation  Resolved through the location (404 for another location's).
     * @return mixed
     */
    public function update(UpdateLocationTranslationRequest $request, Location $location, RuntimeTranslation $locationTranslation)
    {
        return $this->back(
            SaveLocationTranslationCapability::class,
            SaveLocationTranslationParcel::fromArray($request->validated())->setModel($locationTranslation),
            LocationTranslationResource::class,
        );
    }

    /**
     * Delete a translation of a location.
     *
     * @param  DestroyLocationTranslationRequest  $request  Validated deletion payload.
     * @param  Location  $location  Resolved via route-model binding.
     * @param  RuntimeTranslation  $locationTranslation  Resolved through the location (404 for another location's).
     * @return mixed
     */
    public function destroy(DestroyLocationTranslationRequest $request, Location $location, RuntimeTranslation $locationTranslation)
    {
        return $this->back(
            DestroyLocationTranslationCapability::class,
            DestroyLocationTranslationParcel::fromArray(['location_id' => $location->id])->setModel($locationTranslation),
        );
    }
}
