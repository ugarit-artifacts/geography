<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\District;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use Throwable;
use Ugarit\Artifacts\Geography\Contracts\Repositories\District\DistrictRepositoryInterface;
use Ugarit\Artifacts\Geography\Enums\District\Capabilities\IndexDistrictsResult;
use Ugarit\Artifacts\Geography\Models\District;
use Ugarit\Artifacts\Geography\Outcomes\District\DistrictOutcome;
use Ugarit\Artifacts\Geography\Parcels\District\Capabilities\IndexDistrictParcel;

/**
 * Lists the District records matching the criteria: filtered, searched and sorted, as one page or all.
 */
#[Authorize('viewAny', District::class)]
class IndexDistrictsCapability extends Capability
{
    /**
     * @param  DistrictRepositoryInterface  $districts  Data access for this capability.
     */
    public function __construct(protected DistrictRepositoryInterface $districts)
    {
        // Resolved by the container and promoted to $this->districts.
    }

    /**
     * Execute the capability business logic.
     *
     * The parameter type declares the accepted Parcel; a nullable type also accepts no input.
     * Throw a CapabilityException to fail with displayable errors without reporting.
     *
     * @param  IndexDistrictParcel|null  $data  The input parcel.
     * @return Outcome
     */
    protected function perform(?IndexDistrictParcel $data = null): Outcome
    {
        return DistrictOutcome::fromResult(IndexDistrictsResult::SUCCESS, $this->districts->browse($data ?? new IndexDistrictParcel));
    }

    /**
     * Build the outcome returned when perform() throws; unexpected exceptions are already reported.
     *
     * @param  Throwable  $e  The exception raised by perform().
     * @return Outcome
     */
    protected function failed(Throwable $e): Outcome
    {
        return DistrictOutcome::fromResult(IndexDistrictsResult::FAILED);
    }
}
