<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\City\Translation;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use Throwable;
use Ugarit\Artifacts\Geography\Contracts\Repositories\City\CityTranslationRepositoryInterface;
use Ugarit\Artifacts\Geography\Enums\City\Capabilities\Translation\SaveCityTranslationResult;
use Ugarit\Artifacts\Geography\Models\City;
use Ugarit\Artifacts\Geography\Outcomes\City\CityOutcome;
use Ugarit\Artifacts\Geography\Parcels\City\Capabilities\Translation\SaveCityTranslationParcel;

/**
 * Creates or updates the translation of a City for one locale.
 *
 * A parcel without an attached model is addressed by city_id + locale code: the
 * translation of that locale is created, or updated when it exists.
 */
#[Authorize('translate', City::class)]
class SaveCityTranslationCapability extends Capability
{
    /**
     * @param  CityTranslationRepositoryInterface  $translations  City translation data access.
     */
    public function __construct(protected CityTranslationRepositoryInterface $translations)
    {
        // Resolved by the container and promoted to $this->translations.
    }

    /**
     * Persist a translation row.
     *
     * @param  SaveCityTranslationParcel  $data  The translated values, addressed by attached model or city_id + locale.
     * @return Outcome Successful outcome carrying the saved translation.
     */
    protected function perform(SaveCityTranslationParcel $data): Outcome
    {
        return CityOutcome::fromResult(SaveCityTranslationResult::SUCCESS, $this->translations->save($data));
    }

    /**
     * Build the outcome returned when perform() throws (an unknown locale included).
     *
     * @param  Throwable  $e  The reported exception.
     * @return Outcome Failed outcome without payload.
     */
    protected function failed(Throwable $e): Outcome
    {
        return CityOutcome::fromResult(SaveCityTranslationResult::FAILED);
    }
}
