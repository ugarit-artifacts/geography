<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Http\Controllers\Governorate\Features;

use Heritage\Routing\Controller;
use Ugarit\Artifacts\Geography\Features\Governorate\SaveGovernorateFeature;
use Ugarit\Artifacts\Geography\Http\Requests\Governorate\Features\StoreGovernorateRequest;
use Ugarit\Artifacts\Geography\Http\Requests\Governorate\Features\UpdateGovernorateRequest;
use Ugarit\Artifacts\Geography\Http\Resources\Governorate\GovernorateResource;
use Ugarit\Artifacts\Geography\Models\Governorate;
use Ugarit\Artifacts\Geography\Parcels\Governorate\Features\SaveGovernorateParcel;

/**
 * Handles the HTTP endpoints of the Governorate features: saving a governorate with its translations.
 */
class GovernorateController extends Controller
{
    /**
     * Create a governorate with its translations.
     *
     * @param  StoreGovernorateRequest  $request  Validated creation payload.
     * @return mixed
     */
    public function store(StoreGovernorateRequest $request)
    {
        return $this->back(SaveGovernorateFeature::class, SaveGovernorateParcel::fromArray($request->validated()), GovernorateResource::class);
    }

    /**
     * Update a governorate and its translations.
     *
     * @param  UpdateGovernorateRequest  $request  Validated update payload.
     * @param  Governorate  $governorate  Resolved via route-model binding.
     * @return mixed
     */
    public function update(UpdateGovernorateRequest $request, Governorate $governorate)
    {
        return $this->back(SaveGovernorateFeature::class, SaveGovernorateParcel::fromArray($request->validated())->setModel($governorate), GovernorateResource::class);
    }
}
