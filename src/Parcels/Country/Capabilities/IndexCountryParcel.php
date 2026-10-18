<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\Country\Capabilities;

use Heritage\Parcels\QueryParcel;

/**
 * The criteria of the Country listing, read from the query string with fromQuery():
 * `search`, `sort` (`-column` descending), `page`, `per_page` and the filters below.
 */
class IndexCountryParcel extends QueryParcel
{
    /**
     * Create a new Parcel instance; each parameter is a filter, applied when it is not null.
     *
     * @param  bool|null  $active  Only the records with this active.
     */
    public function __construct(
        public ?bool $active = null,
    ) {}

    /**
     * The columns the search term is matched against.
     *
     * @return array<int, string>
     */
    public function searchable(): array
    {
        return ['name', 'code', 'native_name'];
    }

    /**
     * The columns the listing may be sorted by.
     *
     * @return array<int, string>
     */
    public function sortable(): array
    {
        return ['name', 'code', 'native_name', 'created_at'];
    }
}
