<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\Governorate\Translation;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use InvalidArgumentException;
use Throwable;
use Ugarit\Artifacts\Geography\Contracts\Repositories\Governorate\GovernorateTranslationRepositoryInterface;
use Ugarit\Artifacts\Geography\Enums\Governorate\Capabilities\Translation\DestroyGovernorateTranslationResult;
use Ugarit\Artifacts\Geography\Models\Governorate;
use Ugarit\Artifacts\Geography\Outcomes\Governorate\GovernorateOutcome;
use Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities\Translation\DestroyGovernorateTranslationParcel;

/**
 * Deletes the translation of a Governorate: an attached translation model, or the
 * translation of governorate_id + locale code.
 */
#[Authorize('translate', Governorate::class)]
class DestroyGovernorateTranslationCapability extends Capability
{
    /**
     * @param  GovernorateTranslationRepositoryInterface  $translations  Governorate translation data access.
     */
    public function __construct(protected GovernorateTranslationRepositoryInterface $translations)
    {
        // Resolved by the container and promoted to $this->translations.
    }

    /**
     * Delete a translation row.
     *
     * @param  DestroyGovernorateTranslationParcel  $data  The attached translation model, or governorate_id + locale.
     * @return Outcome Successful outcome, also when the locale had no translation.
     *
     * @throws InvalidArgumentException When the parcel addresses no translation (reported, then failed()).
     */
    protected function perform(DestroyGovernorateTranslationParcel $data): Outcome
    {
        if (! $data->getModel() && ($data->governorate_id === null || $data->locale === null)) {
            throw new InvalidArgumentException('A translation is addressed by an attached model or by governorate_id and locale.');
        }

        // Deleting a locale without a translation is a no-op, not a failure.
        $data->getModel()
            ? $this->translations->destroy($data)
            : $this->translations->destroyForLocale($data->governorate_id, $data->locale);

        return GovernorateOutcome::fromResult(DestroyGovernorateTranslationResult::SUCCESS);
    }

    /**
     * Build the outcome returned when perform() throws.
     *
     * @param  Throwable  $e  The reported exception.
     * @return Outcome Failed outcome without payload.
     */
    protected function failed(Throwable $e): Outcome
    {
        return GovernorateOutcome::fromResult(DestroyGovernorateTranslationResult::FAILED);
    }
}
