<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\Governorate\Translation;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use Throwable;
use Ugarit\Artifacts\Geography\Contracts\Repositories\Governorate\GovernorateTranslationRepositoryInterface;
use Ugarit\Artifacts\Geography\Enums\Governorate\Capabilities\Translation\SaveGovernorateTranslationResult;
use Ugarit\Artifacts\Geography\Models\Governorate;
use Ugarit\Artifacts\Geography\Outcomes\Governorate\GovernorateOutcome;
use Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities\Translation\SaveGovernorateTranslationParcel;

/**
 * Creates or updates the translation of a Governorate for one locale.
 *
 * A parcel without an attached model is addressed by governorate_id + locale code: the
 * translation of that locale is created, or updated when it exists.
 */
#[Authorize('translate', Governorate::class)]
class SaveGovernorateTranslationCapability extends Capability
{
    /**
     * @param  GovernorateTranslationRepositoryInterface  $translations  Governorate translation data access.
     */
    public function __construct(protected GovernorateTranslationRepositoryInterface $translations)
    {
        // Resolved by the container and promoted to $this->translations.
    }

    /**
     * Persist a translation row.
     *
     * @param  SaveGovernorateTranslationParcel  $data  The translated values, addressed by attached model or governorate_id + locale.
     * @return Outcome Successful outcome carrying the saved translation.
     */
    protected function perform(SaveGovernorateTranslationParcel $data): Outcome
    {
        return GovernorateOutcome::fromResult(SaveGovernorateTranslationResult::SUCCESS, $this->translations->save($data));
    }

    /**
     * Build the outcome returned when perform() throws (an unknown locale included).
     *
     * @param  Throwable  $e  The reported exception.
     * @return Outcome Failed outcome without payload.
     */
    protected function failed(Throwable $e): Outcome
    {
        return GovernorateOutcome::fromResult(SaveGovernorateTranslationResult::FAILED);
    }
}
