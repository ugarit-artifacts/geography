<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\Location;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use Throwable;
use Ugarit\Artifacts\Geography\Contracts\Repositories\Location\LocationRepositoryInterface;
use Ugarit\Artifacts\Geography\Enums\Location\Capabilities\EditLocationResult;
use Ugarit\Artifacts\Geography\Models\Location;
use Ugarit\Artifacts\Geography\Outcomes\Location\LocationOutcome;
use Ugarit\Artifacts\Geography\Parcels\Location\Capabilities\EditLocationParcel;

/**
 * Loads a Location with its translations for its edit form.
 */
#[Authorize('update', Location::class)]
class EditLocationCapability extends Capability
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
     * @param  EditLocationParcel  $data  The input parcel.
     * @return Outcome
     */
    protected function perform(EditLocationParcel $data): Outcome
    {
        $location = $data->getModel() ?? $this->locations->find($data->id);

        if (! $location) {
            return LocationOutcome::fromResult(EditLocationResult::FAILED);
        }

        return LocationOutcome::fromResult(EditLocationResult::SUCCESS, $location->loadMissing(['translations']));
    }

    /**
     * Build the outcome returned when perform() throws; unexpected exceptions are already reported.
     *
     * @param  Throwable  $e  The exception raised by perform().
     * @return Outcome
     */
    protected function failed(Throwable $e): Outcome
    {
        return LocationOutcome::fromResult(EditLocationResult::FAILED);
    }
}
