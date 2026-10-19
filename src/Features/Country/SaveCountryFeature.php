<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Features\Country;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Features\Feature;
use Heritage\Features\Flow\Call;
use Heritage\Features\Flow\FlowState;
use Heritage\Outcomes\Outcome;
use Heritage\Translation\Locales;
use Ugarit\Artifacts\Geography\Capabilities\Country\SaveCountryCapability;
use Ugarit\Artifacts\Geography\Capabilities\Country\ShowCountryCapability;
use Ugarit\Artifacts\Geography\Capabilities\Country\Translation\DestroyCountryTranslationCapability;
use Ugarit\Artifacts\Geography\Capabilities\Country\Translation\SaveCountryTranslationCapability;
use Ugarit\Artifacts\Geography\Enums\Country\Features\SaveCountryResult;
use Ugarit\Artifacts\Geography\Models\Country;
use Ugarit\Artifacts\Geography\Outcomes\Country\CountryOutcome;
use Ugarit\Artifacts\Geography\Parcels\Country\Capabilities\SaveCountryParcel as SaveCountryCapabilityParcel;
use Ugarit\Artifacts\Geography\Parcels\Country\Capabilities\ShowCountryParcel;
use Ugarit\Artifacts\Geography\Parcels\Country\Capabilities\Translation\DestroyCountryTranslationParcel;
use Ugarit\Artifacts\Geography\Parcels\Country\Capabilities\Translation\SaveCountryTranslationParcel;
use Ugarit\Artifacts\Geography\Parcels\Country\Features\SaveCountryParcel as SaveCountryFeatureParcel;

/**
 * Saves a country with its translations.
 *
 * Flow, inside one transaction:
 * 1. country: SaveCountryCapability saves the country's own columns.
 * 2. translations: for each locale of the payload (['ar' => ['name' => ...], 'en' => null]),
 *    SaveCountryTranslationCapability creates or updates it, DestroyCountryTranslationCapability
 *    deletes a locale sent as null. Omitted locales are left untouched.
 * 3. countryWithTranslations: ShowCountryCapability loads the saved country with its translations.
 *
 * Any failed step rolls the whole save back and returns a CountryOutcome with the step's result.
 */
#[Authorize('save', Country::class)]
class SaveCountryFeature extends Feature
{
    /**
     * Save the country, then each locale of its translations payload, in one transaction.
     *
     * @param  SaveCountryFeatureParcel  $data  The validated input; an attached country is updated.
     * @return Outcome SUCCESS (or SUCCESS_NO_TRANSLATION) with the saved country; on a failed step, the
     *                 step's result with its reason in `errors` (keyed `translations.{locale}` for a locale).
     */
    protected function perform(SaveCountryFeatureParcel $data): Outcome
    {
        return $this->flow(CountryOutcome::class, SaveCountryResult::FAILED)
            ->step('country', SaveCountryCapability::class, SaveCountryCapabilityParcel::fromParcel($data),
                failWith: SaveCountryResult::FAILED_MODEL_SAVE)

            ->each('translations', $data->translations ?? [],
                fn (?array $attributes, string $locale, FlowState $state) => $this->translationCall($state->country->id, $locale, $attributes),
                errorKey: 'translations.{key}',
                context: fn (FlowState $state, string $locale) => [
                    'entity' => $state->country->getRouteKey(),
                    'locale' => Locales::resolver()->label($locale),
                ])

            ->step('countryWithTranslations', ShowCountryCapability::class,
                fn (FlowState $state) => new ShowCountryParcel(id: $state->country->id))

            ->finish(fn (FlowState $state) => CountryOutcome::fromResult(
                empty($data->translations) ? SaveCountryResult::SUCCESS_NO_TRANSLATION : SaveCountryResult::SUCCESS,
                $state->countryWithTranslations
            ));
    }

    /**
     * The call saving a locale, or deleting it when sent as null.
     *
     * @param  int  $countryId
     * @param  string  $locale
     * @param  array<string, mixed>|null  $attributes
     * @return Call
     */
    protected function translationCall(int $countryId, string $locale, ?array $attributes): Call
    {
        if ($attributes === null) {
            return Call::to(DestroyCountryTranslationCapability::class, new DestroyCountryTranslationParcel(country_id: $countryId, locale: $locale))
                ->failWith(SaveCountryResult::FAILED_TRANSLATION_DESTROY);
        }

        return Call::to(SaveCountryTranslationCapability::class, SaveCountryTranslationParcel::fromArray([...$attributes, 'country_id' => $countryId, 'locale' => $locale]))
            ->failWith(SaveCountryResult::FAILED_TRANSLATION_SAVE);
    }
}
