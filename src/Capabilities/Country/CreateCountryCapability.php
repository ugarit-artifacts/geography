<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\Country;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use Throwable;
use Ugarit\Artifacts\Geography\Enums\Country\Capabilities\CreateCountryResult;
use Ugarit\Artifacts\Geography\Models\Country;
use Ugarit\Artifacts\Geography\Outcomes\Country\CountryOutcome;
use Ugarit\Artifacts\Geography\Parcels\Country\Capabilities\CreateCountryParcel;

/**
 * Prepares the Country creation form (no persistence).
 */
#[Authorize('create', Country::class)]
class CreateCountryCapability extends Capability
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
     * @param  CreateCountryParcel|null  $data  The input parcel.
     * @return Outcome
     */
    protected function perform(?CreateCountryParcel $data = null): Outcome
    {
        return CountryOutcome::fromResult(CreateCountryResult::SUCCESS);
    }

    /**
     * Build the outcome returned when perform() throws; unexpected exceptions are already reported.
     *
     * @param  Throwable  $e  The exception raised by perform().
     * @return Outcome
     */
    protected function failed(Throwable $e): Outcome
    {
        return CountryOutcome::fromResult(CreateCountryResult::FAILED);
    }
}
