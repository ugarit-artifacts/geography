<?php

namespace Ugarit\Artifacts\Geography\Repositories\Location;

use Heritage\Repositories\ModelRepository;
use Ugarit\Artifacts\Geography\Contracts\Repositories\Location\LocationRepositoryInterface;
use Ugarit\Artifacts\Geography\Models\Location;

/**
 * Persistence of Location records.
 *
 * Override query() to eager-load relations on every read, and add filter{Name}() methods to
 * change how browse() applies a filter.
 *
 * @extends ModelRepository<Location>
 */
class LocationRepository extends ModelRepository implements LocationRepositoryInterface
{
    /**
     * Create a new repository instance.
     *
     * @param  Location  $model
     */
    public function __construct(Location $model)
    {
        parent::__construct($model);
    }
}
