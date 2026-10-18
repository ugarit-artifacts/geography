<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Capabilities\District\Translation;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Capabilities\Capability;
use Heritage\Outcomes\Outcome;
use Throwable;
use Ugarit\Artifacts\Geography\Contracts\Repositories\District\DistrictTranslationRepositoryInterface;
use Ugarit\Artifacts\Geography\Enums\District\Capabilities\Translation\SaveDistrictTranslationResult;
use Ugarit\Artifacts\Geography\Models\District;
use Ugarit\Artifacts\Geography\Outcomes\District\DistrictOutcome;
use Ugarit\Artifacts\Geography\Parcels\District\Capabilities\Translation\SaveDistrictTranslationParcel;

/**
 * Creates or updates the translation of a District for one locale.
 *
 * A parcel without an attached model is addressed by district_id + locale code: the
 * translation of that locale is created, or updated when it exists.
 */
#[Authorize('translate', District::class)]
class SaveDistrictTranslationCapability extends Capability
{
    /**
     * @param  DistrictTranslationRepositoryInterface  $translations  District translation data access.
     */
    public function __construct(protected DistrictTranslationRepositoryInterface $translations)
    {
        // Resolved by the container and promoted to $this->translations.
    }

    /**
     * Persist a translation row.
     *
     * @param  SaveDistrictTranslationParcel  $data  The translated values, addressed by attached model or district_id + locale.
     * @return Outcome Successful outcome carrying the saved translation.
     */
    protected function perform(SaveDistrictTranslationParcel $data): Outcome
    {
        return DistrictOutcome::fromResult(SaveDistrictTranslationResult::SUCCESS, $this->translations->save($data));
    }

    /**
     * Build the outcome returned when perform() throws (an unknown locale included).
     *
     * @param  Throwable  $e  The reported exception.
     * @return Outcome Failed outcome without payload.
     */
    protected function failed(Throwable $e): Outcome
    {
        return DistrictOutcome::fromResult(SaveDistrictTranslationResult::FAILED);
    }
}
