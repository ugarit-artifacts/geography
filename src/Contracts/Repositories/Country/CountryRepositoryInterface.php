<?php

namespace Ugarit\Artifacts\Geography\Contracts\Repositories\Country;

use Heritage\Contracts\Repositories\ModelRepositoryInterface;
use Ugarit\Artifacts\Geography\Models\Country;

/**
 * Repository contract of Country, injected into its capabilities and bound to
 * CountryRepository by convention.
 *
 * @extends ModelRepositoryInterface<Country>
 */
interface CountryRepositoryInterface extends ModelRepositoryInterface
{
    //
}
