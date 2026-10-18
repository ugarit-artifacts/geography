<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities\Translation;

use Heritage\Parcels\Parcel;

/**
 * Parcel used when deleting the translation of a Governorate.
 *
 * Addressed by an attached translation model, or by governorate_id + locale code.
 */
class DestroyGovernorateTranslationParcel extends Parcel
{
    /**
     * Create a new parcel instance.
     *
     * @param  int|null  $governorate_id  The translated governorate.
     * @param  string|null  $locale  Locale code ("ar", "en").
     */
    public function __construct(
        public ?int $governorate_id = null,
        public ?string $locale = null,
    ) {}
}
