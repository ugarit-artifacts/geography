<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\District\Capabilities\Translation;

use Heritage\Parcels\Parcel;

/**
 * Parcel used when deleting the translation of a District.
 *
 * Addressed by an attached translation model, or by district_id + locale code.
 */
class DestroyDistrictTranslationParcel extends Parcel
{
    /**
     * Create a new parcel instance.
     *
     * @param  int|null  $district_id  The translated district.
     * @param  string|null  $locale  Locale code ("ar", "en").
     */
    public function __construct(
        public ?int $district_id = null,
        public ?string $locale = null,
    ) {}
}
