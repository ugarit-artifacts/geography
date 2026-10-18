<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\District;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use Throwable;
use Ugarit\Artifacts\Geography\Enums\District\Capabilities\CreateDistrictResult;
use Ugarit\Artifacts\Geography\Models\District;
use Ugarit\Artifacts\Geography\Outcomes\District\DistrictOutcome;
use Ugarit\Artifacts\Geography\Parcels\District\Capabilities\CreateDistrictParcel;

/**
 * Prepares the District creation form (no persistence).
 */
#[Authorize('create', District::class)]
class CreateDistrictCapability extends Capability
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
     * @param  CreateDistrictParcel|null  $data  The input parcel.
     * @return Outcome
     */
    protected function perform(?CreateDistrictParcel $data = null): Outcome
    {
        return DistrictOutcome::fromResult(CreateDistrictResult::SUCCESS);
    }

    /**
     * Build the outcome returned when perform() throws; unexpected exceptions are already reported.
     *
     * @param  Throwable  $e  The exception raised by perform().
     * @return Outcome
     */
    protected function failed(Throwable $e): Outcome
    {
        return DistrictOutcome::fromResult(CreateDistrictResult::FAILED);
    }
}
