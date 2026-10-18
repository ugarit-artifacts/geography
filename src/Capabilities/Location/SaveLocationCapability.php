<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\Location;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Capabilities\CapabilityException;
use Heritage\Outcomes\Outcome;
use Throwable;
use Ugarit\Artifacts\Geography\Contracts\Repositories\Location\LocationRepositoryInterface;
use Ugarit\Artifacts\Geography\Enums\Location\Capabilities\SaveLocationResult;
use Ugarit\Artifacts\Geography\Models\District;
use Ugarit\Artifacts\Geography\Models\Location;
use Ugarit\Artifacts\Geography\Outcomes\Location\LocationOutcome;
use Ugarit\Artifacts\Geography\Parcels\Location\Capabilities\SaveLocationParcel;

/**
 * Creates a Location, or updates the attached one.
 */
#[Authorize('save', Location::class)]
class SaveLocationCapability extends Capability
{
    /**
     * @param  LocationRepositoryInterface  $locations  Data access for this capability.
     */
    public function __construct(protected LocationRepositoryInterface $locations)
    {
        // Resolved by the container and promoted to $this->locations.
    }

    /**
     * Execute the capability business logic.
     *
     * The parameter type declares the accepted Parcel; a nullable type also accepts no input.
     * Throw a CapabilityException to fail with displayable errors without reporting.
     *
     * @param  SaveLocationParcel  $data  The input parcel.
     * @return Outcome
     */
    protected function perform(SaveLocationParcel $data): Outcome
    {
        return LocationOutcome::fromResult(SaveLocationResult::SUCCESS, $this->locations->save($this->alignCity($data)));
    }

    /**
     * A district decides the city. A city sent alongside it must be that district's city;
     * a missing city is taken from the district.
     */
    protected function alignCity(SaveLocationParcel $data): SaveLocationParcel
    {
        $sent = $data->toAttributes();
        $current = $data->getModel();
        $districtId = array_key_exists('district_id', $sent) ? $sent['district_id'] : $current?->district_id;
        $cityId = array_key_exists('city_id', $sent) ? $sent['city_id'] : $current?->city_id;

        if ($districtId === null) {
            return $data;
        }

        $districtCityId = District::query()->whereKey($districtId)->value('city_id');

        if ($districtCityId === null) {
            throw new CapabilityException(['district_id' => ['The selected district is invalid.']], 'Unknown district.');
        }

        if ($cityId !== null && (int) $cityId !== (int) $districtCityId) {
            throw new CapabilityException(
                ['district_id' => ['The district does not belong to this city.']],
                'District and city disagree.',
            );
        }

        if ($cityId === null) {
            return SaveLocationParcel::fromParcel($data, ['city_id' => (int) $districtCityId]);
        }

        return $data;
    }

    /**
     * Build the outcome returned when perform() throws; unexpected exceptions are already reported.
     *
     * @param  Throwable  $e  The exception raised by perform().
     * @return Outcome
     */
    protected function failed(Throwable $e): Outcome
    {
        return LocationOutcome::fromResult(SaveLocationResult::FAILED);
    }
}
