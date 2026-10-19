<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Features\Location;

use Heritage\Capabilities\Attributes\Authorize;
use Heritage\Features\Feature;
use Heritage\Features\Flow\Call;
use Heritage\Features\Flow\FlowState;
use Heritage\Outcomes\Outcome;
use Heritage\Translation\Locales;
use Ugarit\Artifacts\Geography\Capabilities\Location\SaveLocationCapability;
use Ugarit\Artifacts\Geography\Capabilities\Location\ShowLocationCapability;
use Ugarit\Artifacts\Geography\Capabilities\Location\Translation\DestroyLocationTranslationCapability;
use Ugarit\Artifacts\Geography\Capabilities\Location\Translation\SaveLocationTranslationCapability;
use Ugarit\Artifacts\Geography\Enums\Location\Features\SaveLocationResult;
use Ugarit\Artifacts\Geography\Models\Location;
use Ugarit\Artifacts\Geography\Outcomes\Location\LocationOutcome;
use Ugarit\Artifacts\Geography\Parcels\Location\Capabilities\SaveLocationParcel as SaveLocationCapabilityParcel;
use Ugarit\Artifacts\Geography\Parcels\Location\Capabilities\ShowLocationParcel;
use Ugarit\Artifacts\Geography\Parcels\Location\Capabilities\Translation\DestroyLocationTranslationParcel;
use Ugarit\Artifacts\Geography\Parcels\Location\Capabilities\Translation\SaveLocationTranslationParcel;
use Ugarit\Artifacts\Geography\Parcels\Location\Features\SaveLocationParcel as SaveLocationFeatureParcel;

/**
 * Saves a location with its translations.
 *
 * Flow, inside one transaction:
 * 1. location: SaveLocationCapability saves the location's own columns.
 * 2. translations: for each locale of the payload (['ar' => ['name' => ...], 'en' => null]),
 *    SaveLocationTranslationCapability creates or updates it, DestroyLocationTranslationCapability
 *    deletes a locale sent as null. Omitted locales are left untouched.
 * 3. locationWithTranslations: ShowLocationCapability loads the saved location with its translations.
 *
 * Any failed step rolls the whole save back and returns a LocationOutcome with the step's result.
 */
#[Authorize('save', Location::class)]
class SaveLocationFeature extends Feature
{
    /**
     * Save the location, then each locale of its translations payload, in one transaction.
     *
     * @param  SaveLocationFeatureParcel  $data  The validated input; an attached location is updated.
     * @return Outcome SUCCESS (or SUCCESS_NO_TRANSLATION) with the saved location; on a failed step, the
     *                 step's result with its reason in `errors` (keyed `translations.{locale}` for a locale).
     */
    protected function perform(SaveLocationFeatureParcel $data): Outcome
    {
        return $this->flow(LocationOutcome::class, SaveLocationResult::FAILED)
            ->step('location', SaveLocationCapability::class, SaveLocationCapabilityParcel::fromParcel($data),
                failWith: SaveLocationResult::FAILED_MODEL_SAVE)

            ->each('translations', $data->translations ?? [],
                fn (?array $attributes, string $locale, FlowState $state) => $this->translationCall($state->location->id, $locale, $attributes),
                errorKey: 'translations.{key}',
                context: fn (FlowState $state, string $locale) => [
                    'entity' => $state->location->getRouteKey(),
                    'locale' => Locales::resolver()->label($locale),
                ])

            ->step('locationWithTranslations', ShowLocationCapability::class,
                fn (FlowState $state) => new ShowLocationParcel(id: $state->location->id))

            ->finish(fn (FlowState $state) => LocationOutcome::fromResult(
                empty($data->translations) ? SaveLocationResult::SUCCESS_NO_TRANSLATION : SaveLocationResult::SUCCESS,
                $state->locationWithTranslations
            ));
    }

    /**
     * The call saving a locale, or deleting it when sent as null.
     *
     * @param  int  $locationId
     * @param  string  $locale
     * @param  array<string, mixed>|null  $attributes
     * @return Call
     */
    protected function translationCall(int $locationId, string $locale, ?array $attributes): Call
    {
        if ($attributes === null) {
            return Call::to(DestroyLocationTranslationCapability::class, new DestroyLocationTranslationParcel(location_id: $locationId, locale: $locale))
                ->failWith(SaveLocationResult::FAILED_TRANSLATION_DESTROY);
        }

        return Call::to(SaveLocationTranslationCapability::class, SaveLocationTranslationParcel::fromArray([...$attributes, 'location_id' => $locationId, 'locale' => $locale]))
            ->failWith(SaveLocationResult::FAILED_TRANSLATION_SAVE);
    }
}
