<?php

namespace Ugarit\Artifacts\Geography\Repositories\Country;

use Heritage\Repositories\ModelRepository;
use Ugarit\Artifacts\Geography\Contracts\Repositories\Country\CountryRepositoryInterface;
use Ugarit\Artifacts\Geography\Models\Country;

/**
 * Persistence of Country records.
 *
 * Override query() to eager-load relations on every read, and add filter{Name}() methods to
 * change how browse() applies a filter.
 *
 * @extends ModelRepository<Country>
 */
class CountryRepository extends ModelRepository implements CountryRepositoryInterface
{
    /**
     * Create a new repository instance.
     *
     * @param  Country  $model
     */
    public function __construct(Country $model)
    {
        parent::__construct($model);
    }
}
