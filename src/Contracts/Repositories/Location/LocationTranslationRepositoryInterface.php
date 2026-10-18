<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Contracts\Repositories\Location;

use Heritage\Contracts\Repositories\TranslationRepositoryInterface;

/**
 * Contract for the persistence of Location translations, addressed by locale code.
 */
interface LocationTranslationRepositoryInterface extends TranslationRepositoryInterface
{
    // Define translation-specific retrieval methods when required.
}
