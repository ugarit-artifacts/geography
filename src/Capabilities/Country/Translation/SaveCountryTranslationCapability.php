<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\Country\Translation;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use Throwable;
use Ugarit\Artifacts\Geography\Contracts\Repositories\Country\CountryTranslationRepositoryInterface;
use Ugarit\Artifacts\Geography\Enums\Country\Capabilities\Translation\SaveCountryTranslationResult;
use Ugarit\Artifacts\Geography\Models\Country;
use Ugarit\Artifacts\Geography\Outcomes\Country\CountryOutcome;
use Ugarit\Artifacts\Geography\Parcels\Country\Capabilities\Translation\SaveCountryTranslationParcel;

/**
 * Creates or updates the translation of a Country for one locale.
 *
 * A parcel without an attached model is addressed by country_id + locale code: the
 * translation of that locale is created, or updated when it exists.
 */
#[Authorize('translate', Country::class)]
class SaveCountryTranslationCapability extends Capability
{
    /**
     * @param  CountryTranslationRepositoryInterface  $translations  Country translation data access.
     */
    public function __construct(protected CountryTranslationRepositoryInterface $translations)
    {
        // Resolved by the container and promoted to $this->translations.
    }

    /**
     * Persist a translation row.
     *
     * @param  SaveCountryTranslationParcel  $data  The translated values, addressed by attached model or country_id + locale.
     * @return Outcome Successful outcome carrying the saved translation.
     */
    protected function perform(SaveCountryTranslationParcel $data): Outcome
    {
        return CountryOutcome::fromResult(SaveCountryTranslationResult::SUCCESS, $this->translations->save($data));
    }

    /**
     * Build the outcome returned when perform() throws (an unknown locale included).
     *
     * @param  Throwable  $e  The reported exception.
     * @return Outcome Failed outcome without payload.
     */
    protected function failed(Throwable $e): Outcome
    {
        return CountryOutcome::fromResult(SaveCountryTranslationResult::FAILED);
    }
}
