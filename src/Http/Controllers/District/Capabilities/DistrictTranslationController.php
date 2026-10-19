<?php

namespace Ugarit\Artifacts\Geography\Http\Controllers\District\Capabilities;

use Heritage\Database\Eloquent\RuntimeTranslation;
use Heritage\Routing\Controller;
use Ugarit\Artifacts\Geography\Capabilities\District\Translation\DestroyDistrictTranslationCapability;
use Ugarit\Artifacts\Geography\Capabilities\District\Translation\SaveDistrictTranslationCapability;
use Ugarit\Artifacts\Geography\Http\Requests\District\Capabilities\Translation\DestroyDistrictTranslationRequest;
use Ugarit\Artifacts\Geography\Http\Requests\District\Capabilities\Translation\StoreDistrictTranslationRequest;
use Ugarit\Artifacts\Geography\Http\Requests\District\Capabilities\Translation\UpdateDistrictTranslationRequest;
use Ugarit\Artifacts\Geography\Http\Resources\District\Translation\DistrictTranslationResource;
use Ugarit\Artifacts\Geography\Models\District;
use Ugarit\Artifacts\Geography\Parcels\District\Capabilities\Translation\DestroyDistrictTranslationParcel;
use Ugarit\Artifacts\Geography\Parcels\District\Capabilities\Translation\SaveDistrictTranslationParcel;

/**
 * Handles the HTTP endpoints of the District translations, nested under their district.
 */
class DistrictTranslationController extends Controller
{
    /**
     * Create the translation of a district for one locale.
     *
     * @param  StoreDistrictTranslationRequest  $request  Validated creation payload.
     * @param  District  $district  Resolved via route-model binding.
     * @return mixed
     */
    public function store(StoreDistrictTranslationRequest $request, District $district)
    {
        return $this->back(
            SaveDistrictTranslationCapability::class,
            SaveDistrictTranslationParcel::fromArray([...$request->validated(), 'district_id' => $district->id]),
            DistrictTranslationResource::class,
        );
    }

    /**
     * Update a translation of a district.
     *
     * @param  UpdateDistrictTranslationRequest  $request  Validated update payload.
     * @param  District  $district  Resolved via route-model binding.
     * @param  RuntimeTranslation  $districtTranslation  Resolved through the district (404 for another district's).
     * @return mixed
     */
    public function update(UpdateDistrictTranslationRequest $request, District $district, RuntimeTranslation $districtTranslation)
    {
        return $this->back(
            SaveDistrictTranslationCapability::class,
            SaveDistrictTranslationParcel::fromArray($request->validated())->setModel($districtTranslation),
            DistrictTranslationResource::class,
        );
    }

    /**
     * Delete a translation of a district.
     *
     * @param  DestroyDistrictTranslationRequest  $request  Validated deletion payload.
     * @param  District  $district  Resolved via route-model binding.
     * @param  RuntimeTranslation  $districtTranslation  Resolved through the district (404 for another district's).
     * @return mixed
     */
    public function destroy(DestroyDistrictTranslationRequest $request, District $district, RuntimeTranslation $districtTranslation)
    {
        return $this->back(
            DestroyDistrictTranslationCapability::class,
            DestroyDistrictTranslationParcel::fromArray(['district_id' => $district->id])->setModel($districtTranslation),
        );
    }
}
