<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities;

use Heritage\Parcels\QueryParcel;

/**
 * The criteria of the Governorate listing, read from the query string with fromQuery():
 * `search`, `sort` (`-column` descending), `page`, `per_page` and the filters below.
 */
class IndexGovernorateParcel extends QueryParcel
{
    /**
     * Create a new Parcel instance; each parameter is a filter, applied when it is not null.
     *
     * @param  int|null  $country_id  Only the records with this country_id.
     * @param  bool|null  $active  Only the records with this active.
     */
    public function __construct(
        public ?int $country_id = null,
        public ?bool $active = null,
    ) {}

    /**
     * The columns the search term is matched against.
     *
     * @return array<int, string>
     */
    public function searchable(): array
    {
        return ['name', 'slug', 'code'];
    }

    /**
     * The columns the listing may be sorted by.
     *
     * @return array<int, string>
     */
    public function sortable(): array
    {
        return ['name', 'slug', 'code', 'created_at'];
    }
}
