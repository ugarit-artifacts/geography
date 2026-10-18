<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Contracts\Repositories\Country;

use Heritage\Contracts\Repositories\TranslationRepositoryInterface;

/**
 * Contract for the persistence of Country translations, addressed by locale code.
 */
interface CountryTranslationRepositoryInterface extends TranslationRepositoryInterface
{
    // Define translation-specific retrieval methods when required.
}
