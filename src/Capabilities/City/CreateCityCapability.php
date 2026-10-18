<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\City;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use Throwable;
use Ugarit\Artifacts\Geography\Enums\City\Capabilities\CreateCityResult;
use Ugarit\Artifacts\Geography\Models\City;
use Ugarit\Artifacts\Geography\Outcomes\City\CityOutcome;
use Ugarit\Artifacts\Geography\Parcels\City\Capabilities\CreateCityParcel;

/**
 * Prepares the City creation form (no persistence).
 */
#[Authorize('create', City::class)]
class CreateCityCapability extends Capability
{
    /**
     * Inject the repository contracts this capability needs, e.g.
     * `protected BranchRepositoryInterface $branches`.
     */
    public function __construct()
    {
        // Promoted constructor parameters are resolved by the container.
    }

    /**
     * Execute the capability business logic.
     *
     * The parameter type declares the accepted Parcel; a nullable type also accepts no input.
     * Throw a CapabilityException to fail with displayable errors without reporting.
     *
     * @param  CreateCityParcel|null  $data  The input parcel.
     * @return Outcome
     */
    protected function perform(?CreateCityParcel $data = null): Outcome
    {
        return CityOutcome::fromResult(CreateCityResult::SUCCESS);
    }

    /**
     * Build the outcome returned when perform() throws; unexpected exceptions are already reported.
     *
     * @param  Throwable  $e  The exception raised by perform().
     * @return Outcome
     */
    protected function failed(Throwable $e): Outcome
    {
        return CityOutcome::fromResult(CreateCityResult::FAILED);
    }
}
