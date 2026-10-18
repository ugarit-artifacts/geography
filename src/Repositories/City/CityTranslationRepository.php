<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Repositories\City;

use Heritage\Database\Eloquent\Model;
use Heritage\Repositories\TranslationRepository;
use Ugarit\Artifacts\Geography\Contracts\Repositories\City\CityTranslationRepositoryInterface;
use Ugarit\Artifacts\Geography\Models\City;

/**
 * Persistence of City translations, addressed by locale code: saving upserts the
 * translation of a city and locale.
 */
class CityTranslationRepository extends TranslationRepository implements CityTranslationRepositoryInterface
{
    /**
     * Create a new repository instance.
     *
     * @param  Model|null  $model  Translation model instance; defaults to the City translation model.
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model ?? (new City)->newTranslation());
    }
}
