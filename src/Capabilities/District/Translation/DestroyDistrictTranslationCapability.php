<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\District\Translation;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use InvalidArgumentException;
use Throwable;
use Ugarit\Artifacts\Geography\Contracts\Repositories\District\DistrictTranslationRepositoryInterface;
use Ugarit\Artifacts\Geography\Enums\District\Capabilities\Translation\DestroyDistrictTranslationResult;
use Ugarit\Artifacts\Geography\Models\District;
use Ugarit\Artifacts\Geography\Outcomes\District\DistrictOutcome;
use Ugarit\Artifacts\Geography\Parcels\District\Capabilities\Translation\DestroyDistrictTranslationParcel;

/**
 * Deletes the translation of a District: an attached translation model, or the
 * translation of district_id + locale code.
 */
#[Authorize('translate', District::class)]
class DestroyDistrictTranslationCapability extends Capability
{
    /**
     * @param  DistrictTranslationRepositoryInterface  $translations  District translation data access.
     */
    public function __construct(protected DistrictTranslationRepositoryInterface $translations)
    {
        // Resolved by the container and promoted to $this->translations.
    }

    /**
     * Delete a translation row.
     *
     * @param  DestroyDistrictTranslationParcel  $data  The attached translation model, or district_id + locale.
     * @return Outcome Successful outcome, also when the locale had no translation.
     *
     * @throws InvalidArgumentException When the parcel addresses no translation (reported, then failed()).
     */
    protected function perform(DestroyDistrictTranslationParcel $data): Outcome
    {
        if (! $data->getModel() && ($data->district_id === null || $data->locale === null)) {
            throw new InvalidArgumentException('A translation is addressed by an attached model or by district_id and locale.');
        }

        // Deleting a locale without a translation is a no-op, not a failure.
        $data->getModel()
            ? $this->translations->destroy($data)
            : $this->translations->destroyForLocale($data->district_id, $data->locale);

        return DistrictOutcome::fromResult(DestroyDistrictTranslationResult::SUCCESS);
    }

    /**
     * Build the outcome returned when perform() throws.
     *
     * @param  Throwable  $e  The reported exception.
     * @return Outcome Failed outcome without payload.
     */
    protected function failed(Throwable $e): Outcome
    {
        return DistrictOutcome::fromResult(DestroyDistrictTranslationResult::FAILED);
    }
}
