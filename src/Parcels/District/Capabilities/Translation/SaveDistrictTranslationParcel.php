<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\District\Capabilities\Translation;

use Heritage\Parcels\Parcel;

/**
 * Parcel used when saving the translation of a District for one locale.
 *
 * Addressed by an attached translation model, or by district_id + locale code.
 */
class SaveDistrictTranslationParcel extends Parcel
{
    /**
     * Create a new parcel instance.
     *
     * @param  int|null  $district_id  The translated district.
     * @param  string|null  $locale  Locale code ("ar", "en").
     * @param  string|null  $name  Translated name.
     */
    public function __construct(
        public ?int $district_id = null,
        public ?string $locale = null,
        public ?string $name = null,
    ) {}
}
