<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\Country;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use Throwable;
use Ugarit\Artifacts\Geography\Contracts\Repositories\Country\CountryRepositoryInterface;
use Ugarit\Artifacts\Geography\Enums\Country\Capabilities\IndexCountriesResult;
use Ugarit\Artifacts\Geography\Models\Country;
use Ugarit\Artifacts\Geography\Outcomes\Country\CountryOutcome;
use Ugarit\Artifacts\Geography\Parcels\Country\Capabilities\IndexCountryParcel;

/**
 * Lists the Country records matching the criteria: filtered, searched and sorted, as one page or all.
 */
#[Authorize('viewAny', Country::class)]
class IndexCountriesCapability extends Capability
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
     * @param  IndexCountryParcel|null  $data  The input parcel.
     * @return Outcome
     */
    protected function perform(?IndexCountryParcel $data = null): Outcome
    {
        return CountryOutcome::fromResult(IndexCountriesResult::SUCCESS, $this->countries->browse($data ?? new IndexCountryParcel));
    }

    /**
     * Build the outcome returned when perform() throws; unexpected exceptions are already reported.
     *
     * @param  Throwable  $e  The exception raised by perform().
     * @return Outcome
     */
    protected function failed(Throwable $e): Outcome
    {
        return CountryOutcome::fromResult(IndexCountriesResult::FAILED);
    }
}
