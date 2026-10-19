<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Http\Controllers\District\Features;

use Heritage\Routing\Controller;
use Ugarit\Artifacts\Geography\Features\District\SaveDistrictFeature;
use Ugarit\Artifacts\Geography\Http\Requests\District\Features\StoreDistrictRequest;
use Ugarit\Artifacts\Geography\Http\Requests\District\Features\UpdateDistrictRequest;
use Ugarit\Artifacts\Geography\Http\Resources\District\DistrictResource;
use Ugarit\Artifacts\Geography\Models\District;
use Ugarit\Artifacts\Geography\Parcels\District\Features\SaveDistrictParcel;

/**
 * Handles the HTTP endpoints of the District features: saving a district with its translations.
 */
class DistrictController extends Controller
{
    /**
     * Create a district with its translations.
     *
     * @param  StoreDistrictRequest  $request  Validated creation payload.
     * @return mixed
     */
    public function store(StoreDistrictRequest $request)
    {
        return $this->back(SaveDistrictFeature::class, SaveDistrictParcel::fromArray($request->validated()), DistrictResource::class);
    }

    /**
     * Update a district and its translations.
     *
     * @param  UpdateDistrictRequest  $request  Validated update payload.
     * @param  District  $district  Resolved via route-model binding.
     * @return mixed
     */
    public function update(UpdateDistrictRequest $request, District $district)
    {
        return $this->back(SaveDistrictFeature::class, SaveDistrictParcel::fromArray($request->validated())->setModel($district), DistrictResource::class);
    }
}
