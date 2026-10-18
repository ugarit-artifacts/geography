<?php

namespace Ugarit\Artifacts\Geography\Repositories\Governorate;

use Heritage\Repositories\ModelRepository;
use Ugarit\Artifacts\Geography\Contracts\Repositories\Governorate\GovernorateRepositoryInterface;
use Ugarit\Artifacts\Geography\Models\Governorate;

/**
 * Persistence of Governorate records.
 *
 * Override query() to eager-load relations on every read, and add filter{Name}() methods to
 * change how browse() applies a filter.
 *
 * @extends ModelRepository<Governorate>
 */
class GovernorateRepository extends ModelRepository implements GovernorateRepositoryInterface
{
    /**
     * Create a new repository instance.
     *
     * @param  Governorate  $model
     */
    public function __construct(Governorate $model)
    {
        parent::__construct($model);
    }
}
