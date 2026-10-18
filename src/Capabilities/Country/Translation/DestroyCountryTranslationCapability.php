<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\Country\Translation;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use InvalidArgumentException;
use Throwable;
use Ugarit\Artifacts\Geography\Contracts\Repositories\Country\CountryTranslationRepositoryInterface;
use Ugarit\Artifacts\Geography\Enums\Country\Capabilities\Translation\DestroyCountryTranslationResult;
use Ugarit\Artifacts\Geography\Models\Country;
use Ugarit\Artifacts\Geography\Outcomes\Country\CountryOutcome;
use Ugarit\Artifacts\Geography\Parcels\Country\Capabilities\Translation\DestroyCountryTranslationParcel;

/**
 * Deletes the translation of a Country: an attached translation model, or the
 * translation of country_id + locale code.
 */
#[Authorize('translate', Country::class)]
class DestroyCountryTranslationCapability extends Capability
{
    /**
     * @param  CountryTranslationRepositoryInterface  $translations  Country translation data access.
     */
    public function __construct(protected CountryTranslationRepositoryInterface $translations)
    {
        // Resolved by the container and promoted to $this->translations.
    }

    /**
     * Delete a translation row.
     *
     * @param  DestroyCountryTranslationParcel  $data  The attached translation model, or country_id + locale.
     * @return Outcome Successful outcome, also when the locale had no translation.
     *
     * @throws InvalidArgumentException When the parcel addresses no translation (reported, then failed()).
     */
    protected function perform(DestroyCountryTranslationParcel $data): Outcome
    {
        if (! $data->getModel() && ($data->country_id === null || $data->locale === null)) {
            throw new InvalidArgumentException('A translation is addressed by an attached model or by country_id and locale.');
        }

        // Deleting a locale without a translation is a no-op, not a failure.
        $data->getModel()
            ? $this->translations->destroy($data)
            : $this->translations->destroyForLocale($data->country_id, $data->locale);

        return CountryOutcome::fromResult(DestroyCountryTranslationResult::SUCCESS);
    }

    /**
     * Build the outcome returned when perform() throws.
     *
     * @param  Throwable  $e  The reported exception.
     * @return Outcome Failed outcome without payload.
     */
    protected function failed(Throwable $e): Outcome
    {
        return CountryOutcome::fromResult(DestroyCountryTranslationResult::FAILED);
    }
}
