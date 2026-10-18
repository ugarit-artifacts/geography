<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\Governorate;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use Throwable;
use Ugarit\Artifacts\Geography\Enums\Governorate\Capabilities\CreateGovernorateResult;
use Ugarit\Artifacts\Geography\Models\Governorate;
use Ugarit\Artifacts\Geography\Outcomes\Governorate\GovernorateOutcome;
use Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities\CreateGovernorateParcel;

/**
 * Prepares the Governorate creation form (no persistence).
 */
#[Authorize('create', Governorate::class)]
class CreateGovernorateCapability extends Capability
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
     * @param  CreateGovernorateParcel|null  $data  The input parcel.
     * @return Outcome
     */
    protected function perform(?CreateGovernorateParcel $data = null): Outcome
    {
        return GovernorateOutcome::fromResult(CreateGovernorateResult::SUCCESS);
    }

    /**
     * Build the outcome returned when perform() throws; unexpected exceptions are already reported.
     *
     * @param  Throwable  $e  The exception raised by perform().
     * @return Outcome
     */
    protected function failed(Throwable $e): Outcome
    {
        return GovernorateOutcome::fromResult(CreateGovernorateResult::FAILED);
    }
}
