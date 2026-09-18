<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Signals;

use Ugarit\Artifacts\Geography\DTOs\CountryDTO;

readonly class CountryCreatedSignal
{
    public function __construct(
        public CountryDTO $country
    ) {}
}
