<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities\Translation;

use Heritage\Parcels\Parcel;

/**
 * Parcel used when saving the translation of a Governorate for one locale.
 *
 * Addressed by an attached translation model, or by governorate_id + locale code.
 */
class SaveGovernorateTranslationParcel extends Parcel
{
    /**
     * Create a new parcel instance.
     *
     * @param  int|null  $governorate_id  The translated governorate.
     * @param  string|null  $locale  Locale code ("ar", "en").
     * @param  string|null  $name  Translated name.
     */
    public function __construct(
        public ?int $governorate_id = null,
        public ?string $locale = null,
        public ?string $name = null,
    ) {}
}
