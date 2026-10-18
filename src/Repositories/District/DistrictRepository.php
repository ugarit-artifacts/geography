<?php

namespace Ugarit\Artifacts\Geography\Repositories\District;

use Heritage\Repositories\ModelRepository;
use Ugarit\Artifacts\Geography\Contracts\Repositories\District\DistrictRepositoryInterface;
use Ugarit\Artifacts\Geography\Models\District;

/**
 * Persistence of District records.
 *
 * Override query() to eager-load relations on every read, and add filter{Name}() methods to
 * change how browse() applies a filter.
 *
 * @extends ModelRepository<District>
 */
class DistrictRepository extends ModelRepository implements DistrictRepositoryInterface
{
    /**
     * Create a new repository instance.
     *
     * @param  District  $model
     */
    public function __construct(District $model)
    {
        parent::__construct($model);
    }
}
