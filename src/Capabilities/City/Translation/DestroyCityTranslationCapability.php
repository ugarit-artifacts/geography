<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\City\Translation;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use InvalidArgumentException;
use Throwable;
use Ugarit\Artifacts\Geography\Contracts\Repositories\City\CityTranslationRepositoryInterface;
use Ugarit\Artifacts\Geography\Enums\City\Capabilities\Translation\DestroyCityTranslationResult;
use Ugarit\Artifacts\Geography\Models\City;
use Ugarit\Artifacts\Geography\Outcomes\City\CityOutcome;
use Ugarit\Artifacts\Geography\Parcels\City\Capabilities\Translation\DestroyCityTranslationParcel;

/**
 * Deletes the translation of a City: an attached translation model, or the
 * translation of city_id + locale code.
 */
#[Authorize('translate', City::class)]
class DestroyCityTranslationCapability extends Capability
{
    /**
     * @param  CityTranslationRepositoryInterface  $translations  City translation data access.
     */
    public function __construct(protected CityTranslationRepositoryInterface $translations)
    {
        // Resolved by the container and promoted to $this->translations.
    }

    /**
     * Delete a translation row.
     *
     * @param  DestroyCityTranslationParcel  $data  The attached translation model, or city_id + locale.
     * @return Outcome Successful outcome, also when the locale had no translation.
     *
     * @throws InvalidArgumentException When the parcel addresses no translation (reported, then failed()).
     */
    protected function perform(DestroyCityTranslationParcel $data): Outcome
    {
        if (! $data->getModel() && ($data->city_id === null || $data->locale === null)) {
            throw new InvalidArgumentException('A translation is addressed by an attached model or by city_id and locale.');
        }

        // Deleting a locale without a translation is a no-op, not a failure.
        $data->getModel()
            ? $this->translations->destroy($data)
            : $this->translations->destroyForLocale($data->city_id, $data->locale);

        return CityOutcome::fromResult(DestroyCityTranslationResult::SUCCESS);
    }

    /**
     * Build the outcome returned when perform() throws.
     *
     * @param  Throwable  $e  The reported exception.
     * @return Outcome Failed outcome without payload.
     */
    protected function failed(Throwable $e): Outcome
    {
        return CityOutcome::fromResult(DestroyCityTranslationResult::FAILED);
    }
}
