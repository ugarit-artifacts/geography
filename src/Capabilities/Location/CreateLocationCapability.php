<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\Location;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use Throwable;
use Ugarit\Artifacts\Geography\Enums\Location\Capabilities\CreateLocationResult;
use Ugarit\Artifacts\Geography\Models\Location;
use Ugarit\Artifacts\Geography\Outcomes\Location\LocationOutcome;
use Ugarit\Artifacts\Geography\Parcels\Location\Capabilities\CreateLocationParcel;

/**
 * Prepares the Location creation form (no persistence).
 */
#[Authorize('create', Location::class)]
class CreateLocationCapability extends Capability
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
     * @param  CreateLocationParcel|null  $data  The input parcel.
     * @return Outcome
     */
    protected function perform(?CreateLocationParcel $data = null): Outcome
    {
        return LocationOutcome::fromResult(CreateLocationResult::SUCCESS);
    }

    /**
     * Build the outcome returned when perform() throws; unexpected exceptions are already reported.
     *
     * @param  Throwable  $e  The exception raised by perform().
     * @return Outcome
     */
    protected function failed(Throwable $e): Outcome
    {
        return LocationOutcome::fromResult(CreateLocationResult::FAILED);
    }
}
