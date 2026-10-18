<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\Country;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use Throwable;
use Ugarit\Artifacts\Geography\Contracts\Repositories\Country\CountryRepositoryInterface;
use Ugarit\Artifacts\Geography\Enums\Country\Capabilities\SaveCountryResult;
use Ugarit\Artifacts\Geography\Models\Country;
use Ugarit\Artifacts\Geography\Outcomes\Country\CountryOutcome;
use Ugarit\Artifacts\Geography\Parcels\Country\Capabilities\SaveCountryParcel;

/**
 * Creates a Country, or updates the attached one.
 */
#[Authorize('save', Country::class)]
class SaveCountryCapability extends Capability
{
    /**
     * @param  CountryRepositoryInterface  $countries  Data access for this capability.
     */
    public function __construct(protected CountryRepositoryInterface $countries)
    {
        // Resolved by the container and promoted to $this->countries.
    }

    /**
     * Execute the capability business logic.
     *
     * The parameter type declares the accepted Parcel; a nullable type also accepts no input.
     * Throw a CapabilityException to fail with displayable errors without reporting.
     *
     * @param  SaveCountryParcel  $data  The input parcel.
     * @return Outcome
     */
    protected function perform(SaveCountryParcel $data): Outcome
    {
        $code = $data->toAttributes()['code'] ?? null;

        if (is_string($code)) {
            $data = SaveCountryParcel::fromParcel($data, ['code' => strtoupper($code)]);
        }

        return CountryOutcome::fromResult(SaveCountryResult::SUCCESS, $this->countries->save($data));
    }

    /**
     * Build the outcome returned when perform() throws; unexpected exceptions are already reported.
     *
     * @param  Throwable  $e  The exception raised by perform().
     * @return Outcome
     */
    protected function failed(Throwable $e): Outcome
    {
        return CountryOutcome::fromResult(SaveCountryResult::FAILED);
    }
}
