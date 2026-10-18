<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\Location;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use Throwable;
use Ugarit\Artifacts\Geography\Contracts\Repositories\Location\LocationRepositoryInterface;
use Ugarit\Artifacts\Geography\Enums\Location\Capabilities\IndexLocationsResult;
use Ugarit\Artifacts\Geography\Models\Location;
use Ugarit\Artifacts\Geography\Outcomes\Location\LocationOutcome;
use Ugarit\Artifacts\Geography\Parcels\Location\Capabilities\IndexLocationParcel;

/**
 * Lists the Location records matching the criteria: filtered, searched and sorted, as one page or all.
 */
#[Authorize('viewAny', Location::class)]
class IndexLocationsCapability extends Capability
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
     * @param  IndexLocationParcel|null  $data  The input parcel.
     * @return Outcome
     */
    protected function perform(?IndexLocationParcel $data = null): Outcome
    {
        return LocationOutcome::fromResult(IndexLocationsResult::SUCCESS, $this->locations->browse($data ?? new IndexLocationParcel));
    }

    /**
     * Build the outcome returned when perform() throws; unexpected exceptions are already reported.
     *
     * @param  Throwable  $e  The exception raised by perform().
     * @return Outcome
     */
    protected function failed(Throwable $e): Outcome
    {
        return LocationOutcome::fromResult(IndexLocationsResult::FAILED);
    }
}
