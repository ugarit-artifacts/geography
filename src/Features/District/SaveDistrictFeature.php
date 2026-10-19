<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Features\District;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Features\Feature;
use Heritage\Features\Flow\Call;
use Heritage\Features\Flow\FlowState;
use Heritage\Outcomes\Outcome;
use Heritage\Translation\Locales;
use Ugarit\Artifacts\Geography\Capabilities\District\SaveDistrictCapability;
use Ugarit\Artifacts\Geography\Capabilities\District\ShowDistrictCapability;
use Ugarit\Artifacts\Geography\Capabilities\District\Translation\DestroyDistrictTranslationCapability;
use Ugarit\Artifacts\Geography\Capabilities\District\Translation\SaveDistrictTranslationCapability;
use Ugarit\Artifacts\Geography\Enums\District\Features\SaveDistrictResult;
use Ugarit\Artifacts\Geography\Models\District;
use Ugarit\Artifacts\Geography\Outcomes\District\DistrictOutcome;
use Ugarit\Artifacts\Geography\Parcels\District\Capabilities\SaveDistrictParcel as SaveDistrictCapabilityParcel;
use Ugarit\Artifacts\Geography\Parcels\District\Capabilities\ShowDistrictParcel;
use Ugarit\Artifacts\Geography\Parcels\District\Capabilities\Translation\DestroyDistrictTranslationParcel;
use Ugarit\Artifacts\Geography\Parcels\District\Capabilities\Translation\SaveDistrictTranslationParcel;
use Ugarit\Artifacts\Geography\Parcels\District\Features\SaveDistrictParcel as SaveDistrictFeatureParcel;

/**
 * Saves a district with its translations.
 *
 * Flow, inside one transaction:
 * 1. district: SaveDistrictCapability saves the district's own columns.
 * 2. translations: for each locale of the payload (['ar' => ['name' => ...], 'en' => null]),
 *    SaveDistrictTranslationCapability creates or updates it, DestroyDistrictTranslationCapability
 *    deletes a locale sent as null. Omitted locales are left untouched.
 * 3. districtWithTranslations: ShowDistrictCapability loads the saved district with its translations.
 *
 * Any failed step rolls the whole save back and returns a DistrictOutcome with the step's result.
 */
#[Authorize('save', District::class)]
class SaveDistrictFeature extends Feature
{
    /**
     * Save the district, then each locale of its translations payload, in one transaction.
     *
     * @param  SaveDistrictFeatureParcel  $data  The validated input; an attached district is updated.
     * @return Outcome SUCCESS (or SUCCESS_NO_TRANSLATION) with the saved district; on a failed step, the
     *                 step's result with its reason in `errors` (keyed `translations.{locale}` for a locale).
     */
    protected function perform(SaveDistrictFeatureParcel $data): Outcome
    {
        return $this->flow(DistrictOutcome::class, SaveDistrictResult::FAILED)
            ->step('district', SaveDistrictCapability::class, SaveDistrictCapabilityParcel::fromParcel($data),
                failWith: SaveDistrictResult::FAILED_MODEL_SAVE)

            ->each('translations', $data->translations ?? [],
                fn (?array $attributes, string $locale, FlowState $state) => $this->translationCall($state->district->id, $locale, $attributes),
                errorKey: 'translations.{key}',
                context: fn (FlowState $state, string $locale) => [
                    'entity' => $state->district->getRouteKey(),
                    'locale' => Locales::resolver()->label($locale),
                ])

            ->step('districtWithTranslations', ShowDistrictCapability::class,
                fn (FlowState $state) => new ShowDistrictParcel(id: $state->district->id))

            ->finish(fn (FlowState $state) => DistrictOutcome::fromResult(
                empty($data->translations) ? SaveDistrictResult::SUCCESS_NO_TRANSLATION : SaveDistrictResult::SUCCESS,
                $state->districtWithTranslations
            ));
    }

    /**
     * The call saving a locale, or deleting it when sent as null.
     *
     * @param  int  $districtId
     * @param  string  $locale
     * @param  array<string, mixed>|null  $attributes
     * @return Call
     */
    protected function translationCall(int $districtId, string $locale, ?array $attributes): Call
    {
        if ($attributes === null) {
            return Call::to(DestroyDistrictTranslationCapability::class, new DestroyDistrictTranslationParcel(district_id: $districtId, locale: $locale))
                ->failWith(SaveDistrictResult::FAILED_TRANSLATION_DESTROY);
        }

        return Call::to(SaveDistrictTranslationCapability::class, SaveDistrictTranslationParcel::fromArray([...$attributes, 'district_id' => $districtId, 'locale' => $locale]))
            ->failWith(SaveDistrictResult::FAILED_TRANSLATION_SAVE);
    }
}
