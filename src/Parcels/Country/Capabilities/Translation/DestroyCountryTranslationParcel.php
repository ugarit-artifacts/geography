<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\Country\Capabilities\Translation;

use Heritage\Parcels\Parcel;

/**
 * Parcel used when deleting the translation of a Country.
 *
 * Addressed by an attached translation model, or by country_id + locale code.
 */
class DestroyCountryTranslationParcel extends Parcel
{
    /**
     * Create a new parcel instance.
     *
     * @param  int|null  $country_id  The translated country.
     * @param  string|null  $locale  Locale code ("ar", "en").
     */
    public function __construct(
        public ?int $country_id = null,
        public ?string $locale = null,
    ) {}
}
