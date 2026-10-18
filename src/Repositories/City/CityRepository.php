<?php

namespace Ugarit\Artifacts\Geography\Repositories\City;

use Heritage\Repositories\ModelRepository;
use Ugarit\Artifacts\Geography\Contracts\Repositories\City\CityRepositoryInterface;
use Ugarit\Artifacts\Geography\Models\City;

/**
 * Persistence of City records.
 *
 * Override query() to eager-load relations on every read, and add filter{Name}() methods to
 * change how browse() applies a filter.
 *
 * @extends ModelRepository<City>
 */
class CityRepository extends ModelRepository implements CityRepositoryInterface
{
    /**
     * Create a new repository instance.
     *
     * @param  City  $model
     */
    public function __construct(City $model)
    {
        parent::__construct($model);
    }
}
