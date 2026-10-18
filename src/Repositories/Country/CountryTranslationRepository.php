<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Repositories\Country;

use Heritage\Database\Eloquent\Model;
use Heritage\Repositories\TranslationRepository;
use Ugarit\Artifacts\Geography\Contracts\Repositories\Country\CountryTranslationRepositoryInterface;
use Ugarit\Artifacts\Geography\Models\Country;

/**
 * Persistence of Country translations, addressed by locale code: saving upserts the
 * translation of a country and locale.
 */
class CountryTranslationRepository extends TranslationRepository implements CountryTranslationRepositoryInterface
{
    /**
     * Create a new repository instance.
     *
     * @param  Model|null  $model  Translation model instance; defaults to the Country translation model.
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model ?? (new Country)->newTranslation());
    }
}
