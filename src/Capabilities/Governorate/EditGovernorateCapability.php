<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\Governorate;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use Throwable;
use Ugarit\Artifacts\Geography\Contracts\Repositories\Governorate\GovernorateRepositoryInterface;
use Ugarit\Artifacts\Geography\Enums\Governorate\Capabilities\EditGovernorateResult;
use Ugarit\Artifacts\Geography\Models\Governorate;
use Ugarit\Artifacts\Geography\Outcomes\Governorate\GovernorateOutcome;
use Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities\EditGovernorateParcel;

/**
 * Loads a Governorate with its translations for its edit form.
 */
#[Authorize('update', Governorate::class)]
class EditGovernorateCapability extends Capability
{
    /**
     * @param  GovernorateRepositoryInterface  $governorates  Data access for this capability.
     */
    public function __construct(protected GovernorateRepositoryInterface $governorates)
    {
        // Resolved by the container and promoted to $this->governorates.
    }

    /**
     * Execute the capability business logic.
     *
     * The parameter type declares the accepted Parcel; a nullable type also accepts no input.
     * Throw a CapabilityException to fail with displayable errors without reporting.
     *
     * @param  EditGovernorateParcel  $data  The input parcel.
     * @return Outcome
     */
    protected function perform(EditGovernorateParcel $data): Outcome
    {
        $governorate = $data->getModel() ?? $this->governorates->find($data->id);

        if (! $governorate) {
            return GovernorateOutcome::fromResult(EditGovernorateResult::FAILED);
        }

        return GovernorateOutcome::fromResult(EditGovernorateResult::SUCCESS, $governorate->loadMissing(['translations']));
    }

    /**
     * Build the outcome returned when perform() throws; unexpected exceptions are already reported.
     *
     * @param  Throwable  $e  The exception raised by perform().
     * @return Outcome
     */
    protected function failed(Throwable $e): Outcome
    {
        return GovernorateOutcome::fromResult(EditGovernorateResult::FAILED);
    }
}
