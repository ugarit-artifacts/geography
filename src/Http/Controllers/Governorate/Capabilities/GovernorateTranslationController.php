<?php

namespace Ugarit\Artifacts\Geography\Http\Controllers\Governorate\Capabilities;

use Heritage\Database\Eloquent\RuntimeTranslation;
use Heritage\Routing\Controller;
use Ugarit\Artifacts\Geography\Capabilities\Governorate\Translation\DestroyGovernorateTranslationCapability;
use Ugarit\Artifacts\Geography\Capabilities\Governorate\Translation\SaveGovernorateTranslationCapability;
use Ugarit\Artifacts\Geography\Http\Requests\Governorate\Capabilities\Translation\DestroyGovernorateTranslationRequest;
use Ugarit\Artifacts\Geography\Http\Requests\Governorate\Capabilities\Translation\StoreGovernorateTranslationRequest;
use Ugarit\Artifacts\Geography\Http\Requests\Governorate\Capabilities\Translation\UpdateGovernorateTranslationRequest;
use Ugarit\Artifacts\Geography\Http\Resources\Governorate\Translation\GovernorateTranslationResource;
use Ugarit\Artifacts\Geography\Models\Governorate;
use Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities\Translation\DestroyGovernorateTranslationParcel;
use Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities\Translation\SaveGovernorateTranslationParcel;

/**
 * Handles the HTTP endpoints of the Governorate translations, nested under their governorate.
 */
class GovernorateTranslationController extends Controller
{
    /**
     * Create the translation of a governorate for one locale.
     *
     * @param  StoreGovernorateTranslationRequest  $request  Validated creation payload.
     * @param  Governorate  $governorate  Resolved via route-model binding.
     * @return mixed
     */
    public function store(StoreGovernorateTranslationRequest $request, Governorate $governorate)
    {
        return $this->back(
            SaveGovernorateTranslationCapability::class,
            SaveGovernorateTranslationParcel::fromArray([...$request->validated(), 'governorate_id' => $governorate->id]),
            GovernorateTranslationResource::class,
        );
    }

    /**
     * Update a translation of a governorate.
     *
     * @param  UpdateGovernorateTranslationRequest  $request  Validated update payload.
     * @param  Governorate  $governorate  Resolved via route-model binding.
     * @param  RuntimeTranslation  $governorateTranslation  Resolved through the governorate (404 for another governorate's).
     * @return mixed
     */
    public function update(UpdateGovernorateTranslationRequest $request, Governorate $governorate, RuntimeTranslation $governorateTranslation)
    {
        return $this->back(
            SaveGovernorateTranslationCapability::class,
            SaveGovernorateTranslationParcel::fromArray($request->validated())->setModel($governorateTranslation),
            GovernorateTranslationResource::class,
        );
    }

    /**
     * Delete a translation of a governorate.
     *
     * @param  DestroyGovernorateTranslationRequest  $request  Validated deletion payload.
     * @param  Governorate  $governorate  Resolved via route-model binding.
     * @param  RuntimeTranslation  $governorateTranslation  Resolved through the governorate (404 for another governorate's).
     * @return mixed
     */
    public function destroy(DestroyGovernorateTranslationRequest $request, Governorate $governorate, RuntimeTranslation $governorateTranslation)
    {
        return $this->back(
            DestroyGovernorateTranslationCapability::class,
            DestroyGovernorateTranslationParcel::fromArray(['governorate_id' => $governorate->id])->setModel($governorateTranslation),
        );
    }
}
