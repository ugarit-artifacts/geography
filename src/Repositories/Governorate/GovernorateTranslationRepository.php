<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Repositories\Governorate;

use Heritage\Database\Eloquent\Model;
use Heritage\Repositories\TranslationRepository;
use Ugarit\Artifacts\Geography\Contracts\Repositories\Governorate\GovernorateTranslationRepositoryInterface;
use Ugarit\Artifacts\Geography\Models\Governorate;

/**
 * Persistence of Governorate translations, addressed by locale code: saving upserts the
 * translation of a governorate and locale.
 */
class GovernorateTranslationRepository extends TranslationRepository implements GovernorateTranslationRepositoryInterface
{
    /**
     * Create a new repository instance.
     *
     * @param  Model|null  $model  Translation model instance; defaults to the Governorate translation model.
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model ?? (new Governorate)->newTranslation());
    }
}
