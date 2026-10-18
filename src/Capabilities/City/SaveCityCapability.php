<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\City;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use Throwable;
use Ugarit\Artifacts\Geography\Contracts\Repositories\City\CityRepositoryInterface;
use Ugarit\Artifacts\Geography\Enums\City\Capabilities\SaveCityResult;
use Ugarit\Artifacts\Geography\Models\City;
use Ugarit\Artifacts\Geography\Outcomes\City\CityOutcome;
use Ugarit\Artifacts\Geography\Parcels\City\Capabilities\SaveCityParcel;

/**
 * Creates a City, or updates the attached one.
 */
#[Authorize('save', City::class)]
class SaveCityCapability extends Capability
{
    /**
     * @param  CityRepositoryInterface  $cities  Data access for this capability.
     */
    public function __construct(protected CityRepositoryInterface $cities)
    {
        // Resolved by the container and promoted to $this->cities.
    }

    /**
     * Execute the capability business logic.
     *
     * The parameter type declares the accepted Parcel; a nullable type also accepts no input.
     * Throw a CapabilityException to fail with displayable errors without reporting.
     *
     * @param  SaveCityParcel  $data  The input parcel.
     * @return Outcome
     */
    protected function perform(SaveCityParcel $data): Outcome
    {
        return CityOutcome::fromResult(SaveCityResult::SUCCESS, $this->cities->save($data));
    }

    /**
     * Build the outcome returned when perform() throws; unexpected exceptions are already reported.
     *
     * @param  Throwable  $e  The exception raised by perform().
     * @return Outcome
     */
    protected function failed(Throwable $e): Outcome
    {
        return CityOutcome::fromResult(SaveCityResult::FAILED);
    }
}
