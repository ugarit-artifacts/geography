<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Repositories\Location;

use Heritage\Database\Eloquent\Model;
use Heritage\Repositories\TranslationRepository;
use Ugarit\Artifacts\Geography\Contracts\Repositories\Location\LocationTranslationRepositoryInterface;
use Ugarit\Artifacts\Geography\Models\Location;

/**
 * Persistence of Location translations, addressed by locale code: saving upserts the
 * translation of a location and locale.
 */
class LocationTranslationRepository extends TranslationRepository implements LocationTranslationRepositoryInterface
{
    /**
     * Create a new repository instance.
     *
     * @param  Model|null  $model  Translation model instance; defaults to the Location translation model.
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model ?? (new Location)->newTranslation());
    }
}
