<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Features\City;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Features\Feature;
use Heritage\Features\Flow\Call;
use Heritage\Features\Flow\FlowState;
use Heritage\Outcomes\Outcome;
use Heritage\Translation\Locales;
use Ugarit\Artifacts\Geography\Capabilities\City\SaveCityCapability;
use Ugarit\Artifacts\Geography\Capabilities\City\ShowCityCapability;
use Ugarit\Artifacts\Geography\Capabilities\City\Translation\DestroyCityTranslationCapability;
use Ugarit\Artifacts\Geography\Capabilities\City\Translation\SaveCityTranslationCapability;
use Ugarit\Artifacts\Geography\Enums\City\Features\SaveCityResult;
use Ugarit\Artifacts\Geography\Models\City;
use Ugarit\Artifacts\Geography\Outcomes\City\CityOutcome;
use Ugarit\Artifacts\Geography\Parcels\City\Capabilities\SaveCityParcel as SaveCityCapabilityParcel;
use Ugarit\Artifacts\Geography\Parcels\City\Capabilities\ShowCityParcel;
use Ugarit\Artifacts\Geography\Parcels\City\Capabilities\Translation\DestroyCityTranslationParcel;
use Ugarit\Artifacts\Geography\Parcels\City\Capabilities\Translation\SaveCityTranslationParcel;
use Ugarit\Artifacts\Geography\Parcels\City\Features\SaveCityParcel as SaveCityFeatureParcel;

/**
 * Saves a city with its translations.
 *
 * Flow, inside one transaction:
 * 1. city: SaveCityCapability saves the city's own columns.
 * 2. translations: for each locale of the payload (['ar' => ['name' => ...], 'en' => null]),
 *    SaveCityTranslationCapability creates or updates it, DestroyCityTranslationCapability
 *    deletes a locale sent as null. Omitted locales are left untouched.
 * 3. cityWithTranslations: ShowCityCapability loads the saved city with its translations.
 *
 * Any failed step rolls the whole save back and returns a CityOutcome with the step's result.
 */
#[Authorize('save', City::class)]
class SaveCityFeature extends Feature
{
    /**
     * Save the city, then each locale of its translations payload, in one transaction.
     *
     * @param  SaveCityFeatureParcel  $data  The validated input; an attached city is updated.
     * @return Outcome SUCCESS (or SUCCESS_NO_TRANSLATION) with the saved city; on a failed step, the
     *                 step's result with its reason in `errors` (keyed `translations.{locale}` for a locale).
     */
    protected function perform(SaveCityFeatureParcel $data): Outcome
    {
        return $this->flow(CityOutcome::class, SaveCityResult::FAILED)
            ->step('city', SaveCityCapability::class, SaveCityCapabilityParcel::fromParcel($data),
                failWith: SaveCityResult::FAILED_MODEL_SAVE)

            ->each('translations', $data->translations ?? [],
                fn (?array $attributes, string $locale, FlowState $state) => $this->translationCall($state->city->id, $locale, $attributes),
                errorKey: 'translations.{key}',
                context: fn (FlowState $state, string $locale) => [
                    'entity' => $state->city->getRouteKey(),
                    'locale' => Locales::resolver()->label($locale),
                ])

            ->step('cityWithTranslations', ShowCityCapability::class,
                fn (FlowState $state) => new ShowCityParcel(id: $state->city->id))

            ->finish(fn (FlowState $state) => CityOutcome::fromResult(
                empty($data->translations) ? SaveCityResult::SUCCESS_NO_TRANSLATION : SaveCityResult::SUCCESS,
                $state->cityWithTranslations
            ));
    }

    /**
     * The call saving a locale, or deleting it when sent as null.
     *
     * @param  int  $cityId
     * @param  string  $locale
     * @param  array<string, mixed>|null  $attributes
     * @return Call
     */
    protected function translationCall(int $cityId, string $locale, ?array $attributes): Call
    {
        if ($attributes === null) {
            return Call::to(DestroyCityTranslationCapability::class, new DestroyCityTranslationParcel(city_id: $cityId, locale: $locale))
                ->failWith(SaveCityResult::FAILED_TRANSLATION_DESTROY);
        }

        return Call::to(SaveCityTranslationCapability::class, SaveCityTranslationParcel::fromArray([...$attributes, 'city_id' => $cityId, 'locale' => $locale]))
            ->failWith(SaveCityResult::FAILED_TRANSLATION_SAVE);
    }
}
