<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Http\Controllers\Country\Features;

use Heritage\Routing\Controller;
use Ugarit\Artifacts\Geography\Features\Country\SaveCountryFeature;
use Ugarit\Artifacts\Geography\Http\Requests\Country\Features\StoreCountryRequest;
use Ugarit\Artifacts\Geography\Http\Requests\Country\Features\UpdateCountryRequest;
use Ugarit\Artifacts\Geography\Http\Resources\Country\CountryResource;
use Ugarit\Artifacts\Geography\Models\Country;
use Ugarit\Artifacts\Geography\Parcels\Country\Features\SaveCountryParcel;

/**
 * Handles the HTTP endpoints of the Country features: saving a country with its translations.
 */
class CountryController extends Controller
{
    /**
     * Create a country with its translations.
     *
     * @param  StoreCountryRequest  $request  Validated creation payload.
     * @return mixed
     */
    public function store(StoreCountryRequest $request)
    {
        return $this->back(SaveCountryFeature::class, SaveCountryParcel::fromArray($request->validated()), CountryResource::class);
    }

    /**
     * Update a country and its translations.
     *
     * @param  UpdateCountryRequest  $request  Validated update payload.
     * @param  Country  $country  Resolved via route-model binding.
     * @return mixed
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        return $this->back(SaveCountryFeature::class, SaveCountryParcel::fromArray($request->validated())->setModel($country), CountryResource::class);
    }
}
