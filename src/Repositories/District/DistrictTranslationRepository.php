<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Repositories\District;

use Heritage\Database\Eloquent\Model;
use Heritage\Repositories\TranslationRepository;
use Ugarit\Artifacts\Geography\Contracts\Repositories\District\DistrictTranslationRepositoryInterface;
use Ugarit\Artifacts\Geography\Models\District;

/**
 * Persistence of District translations, addressed by locale code: saving upserts the
 * translation of a district and locale.
 */
class DistrictTranslationRepository extends TranslationRepository implements DistrictTranslationRepositoryInterface
{
    /**
     * Create a new repository instance.
     *
     * @param  Model|null  $model  Translation model instance; defaults to the District translation model.
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model ?? (new District)->newTranslation());
    }
}
