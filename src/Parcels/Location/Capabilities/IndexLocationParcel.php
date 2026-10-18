<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\Location\Capabilities;

use Heritage\Parcels\QueryParcel;

/**
 * The criteria of the Location listing, read from the query string with fromQuery():
 * `search`, `sort` (`-column` descending), `page`, `per_page` and the filters below.
 */
class IndexLocationParcel extends QueryParcel
{
    /**
     * Create a new Parcel instance; each parameter is a filter, applied when it is not null.
     *
     * @param  int|null  $city_id  Only the records with this city_id.
     * @param  int|null  $district_id  Only the records with this district_id.
     * @param  bool|null  $active  Only the records with this active.
     */
    public function __construct(
        public ?int $city_id = null,
        public ?int $district_id = null,
        public ?bool $active = null,
    ) {}

    /**
     * The columns the search term is matched against.
     *
     * @return array<int, string>
     */
    public function searchable(): array
    {
        return ['name', 'address_line', 'slug', 'postal_code'];
    }

    /**
     * The columns the listing may be sorted by.
     *
     * @return array<int, string>
     */
    public function sortable(): array
    {
        return ['name', 'address_line', 'slug', 'postal_code', 'created_at'];
    }
}
