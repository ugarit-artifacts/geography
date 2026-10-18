<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\Location\Translation;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use InvalidArgumentException;
use Throwable;
use Ugarit\Artifacts\Geography\Contracts\Repositories\Location\LocationTranslationRepositoryInterface;
use Ugarit\Artifacts\Geography\Enums\Location\Capabilities\Translation\DestroyLocationTranslationResult;
use Ugarit\Artifacts\Geography\Models\Location;
use Ugarit\Artifacts\Geography\Outcomes\Location\LocationOutcome;
use Ugarit\Artifacts\Geography\Parcels\Location\Capabilities\Translation\DestroyLocationTranslationParcel;

/**
 * Deletes the translation of a Location: an attached translation model, or the
 * translation of location_id + locale code.
 */
#[Authorize('translate', Location::class)]
class DestroyLocationTranslationCapability extends Capability
{
    /**
     * @param  LocationTranslationRepositoryInterface  $translations  Location translation data access.
     */
    public function __construct(protected LocationTranslationRepositoryInterface $translations)
    {
        // Resolved by the container and promoted to $this->translations.
    }

    /**
     * Delete a translation row.
     *
     * @param  DestroyLocationTranslationParcel  $data  The attached translation model, or location_id + locale.
     * @return Outcome Successful outcome, also when the locale had no translation.
     *
     * @throws InvalidArgumentException When the parcel addresses no translation (reported, then failed()).
     */
    protected function perform(DestroyLocationTranslationParcel $data): Outcome
    {
        if (! $data->getModel() && ($data->location_id === null || $data->locale === null)) {
            throw new InvalidArgumentException('A translation is addressed by an attached model or by location_id and locale.');
        }

        // Deleting a locale without a translation is a no-op, not a failure.
        $data->getModel()
            ? $this->translations->destroy($data)
            : $this->translations->destroyForLocale($data->location_id, $data->locale);

        return LocationOutcome::fromResult(DestroyLocationTranslationResult::SUCCESS);
    }

    /**
     * Build the outcome returned when perform() throws.
     *
     * @param  Throwable  $e  The reported exception.
     * @return Outcome Failed outcome without payload.
     */
    protected function failed(Throwable $e): Outcome
    {
        return LocationOutcome::fromResult(DestroyLocationTranslationResult::FAILED);
    }
}
