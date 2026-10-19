<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Features\Governorate;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Features\Feature;
use Heritage\Features\Flow\Call;
use Heritage\Features\Flow\FlowState;
use Heritage\Outcomes\Outcome;
use Heritage\Translation\Locales;
use Ugarit\Artifacts\Geography\Capabilities\Governorate\SaveGovernorateCapability;
use Ugarit\Artifacts\Geography\Capabilities\Governorate\ShowGovernorateCapability;
use Ugarit\Artifacts\Geography\Capabilities\Governorate\Translation\DestroyGovernorateTranslationCapability;
use Ugarit\Artifacts\Geography\Capabilities\Governorate\Translation\SaveGovernorateTranslationCapability;
use Ugarit\Artifacts\Geography\Enums\Governorate\Features\SaveGovernorateResult;
use Ugarit\Artifacts\Geography\Models\Governorate;
use Ugarit\Artifacts\Geography\Outcomes\Governorate\GovernorateOutcome;
use Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities\SaveGovernorateParcel as SaveGovernorateCapabilityParcel;
use Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities\ShowGovernorateParcel;
use Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities\Translation\DestroyGovernorateTranslationParcel;
use Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities\Translation\SaveGovernorateTranslationParcel;
use Ugarit\Artifacts\Geography\Parcels\Governorate\Features\SaveGovernorateParcel as SaveGovernorateFeatureParcel;

/**
 * Saves a governorate with its translations.
 *
 * Flow, inside one transaction:
 * 1. governorate: SaveGovernorateCapability saves the governorate's own columns.
 * 2. translations: for each locale of the payload (['ar' => ['name' => ...], 'en' => null]),
 *    SaveGovernorateTranslationCapability creates or updates it, DestroyGovernorateTranslationCapability
 *    deletes a locale sent as null. Omitted locales are left untouched.
 * 3. governorateWithTranslations: ShowGovernorateCapability loads the saved governorate with its translations.
 *
 * Any failed step rolls the whole save back and returns a GovernorateOutcome with the step's result.
 */
#[Authorize('save', Governorate::class)]
class SaveGovernorateFeature extends Feature
{
    /**
     * Save the governorate, then each locale of its translations payload, in one transaction.
     *
     * @param  SaveGovernorateFeatureParcel  $data  The validated input; an attached governorate is updated.
     * @return Outcome SUCCESS (or SUCCESS_NO_TRANSLATION) with the saved governorate; on a failed step, the
     *                 step's result with its reason in `errors` (keyed `translations.{locale}` for a locale).
     */
    protected function perform(SaveGovernorateFeatureParcel $data): Outcome
    {
        return $this->flow(GovernorateOutcome::class, SaveGovernorateResult::FAILED)
            ->step('governorate', SaveGovernorateCapability::class, SaveGovernorateCapabilityParcel::fromParcel($data),
                failWith: SaveGovernorateResult::FAILED_MODEL_SAVE)

            ->each('translations', $data->translations ?? [],
                fn (?array $attributes, string $locale, FlowState $state) => $this->translationCall($state->governorate->id, $locale, $attributes),
                errorKey: 'translations.{key}',
                context: fn (FlowState $state, string $locale) => [
                    'entity' => $state->governorate->getRouteKey(),
                    'locale' => Locales::resolver()->label($locale),
                ])

            ->step('governorateWithTranslations', ShowGovernorateCapability::class,
                fn (FlowState $state) => new ShowGovernorateParcel(id: $state->governorate->id))

            ->finish(fn (FlowState $state) => GovernorateOutcome::fromResult(
                empty($data->translations) ? SaveGovernorateResult::SUCCESS_NO_TRANSLATION : SaveGovernorateResult::SUCCESS,
                $state->governorateWithTranslations
            ));
    }

    /**
     * The call saving a locale, or deleting it when sent as null.
     *
     * @param  int  $governorateId
     * @param  string  $locale
     * @param  array<string, mixed>|null  $attributes
     * @return Call
     */
    protected function translationCall(int $governorateId, string $locale, ?array $attributes): Call
    {
        if ($attributes === null) {
            return Call::to(DestroyGovernorateTranslationCapability::class, new DestroyGovernorateTranslationParcel(governorate_id: $governorateId, locale: $locale))
                ->failWith(SaveGovernorateResult::FAILED_TRANSLATION_DESTROY);
        }

        return Call::to(SaveGovernorateTranslationCapability::class, SaveGovernorateTranslationParcel::fromArray([...$attributes, 'governorate_id' => $governorateId, 'locale' => $locale]))
            ->failWith(SaveGovernorateResult::FAILED_TRANSLATION_SAVE);
    }
}
