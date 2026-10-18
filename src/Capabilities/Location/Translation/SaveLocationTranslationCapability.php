<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\Location\Translation;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use Throwable;
use Ugarit\Artifacts\Geography\Contracts\Repositories\Location\LocationTranslationRepositoryInterface;
use Ugarit\Artifacts\Geography\Enums\Location\Capabilities\Translation\SaveLocationTranslationResult;
use Ugarit\Artifacts\Geography\Models\Location;
use Ugarit\Artifacts\Geography\Outcomes\Location\LocationOutcome;
use Ugarit\Artifacts\Geography\Parcels\Location\Capabilities\Translation\SaveLocationTranslationParcel;

/**
 * Creates or updates the translation of a Location for one locale.
 *
 * A parcel without an attached model is addressed by location_id + locale code: the
 * translation of that locale is created, or updated when it exists.
 */
#[Authorize('translate', Location::class)]
class SaveLocationTranslationCapability extends Capability
{
    /**
     * @param  LocationTranslationRepositoryInterface  $translations  Location translation data access.
     */
    public function __construct(protected LocationTranslationRepositoryInterface $translations)
    {
        // Resolved by the container and promoted to $this->translations.
    }

    /**
     * Persist a translation row.
     *
     * @param  SaveLocationTranslationParcel  $data  The translated values, addressed by attached model or location_id + locale.
     * @return Outcome Successful outcome carrying the saved translation.
     */
    protected function perform(SaveLocationTranslationParcel $data): Outcome
    {
        return LocationOutcome::fromResult(SaveLocationTranslationResult::SUCCESS, $this->translations->save($data));
    }

    /**
     * Build the outcome returned when perform() throws (an unknown locale included).
     *
     * @param  Throwable  $e  The reported exception.
     * @return Outcome Failed outcome without payload.
     */
    protected function failed(Throwable $e): Outcome
    {
        return LocationOutcome::fromResult(SaveLocationTranslationResult::FAILED);
    }
}
