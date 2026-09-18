<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Signals;

use Ugarit\Artifacts\Geography\DTOs\LocationDTO;

readonly class LocationCreatedSignal
{
    public function __construct(
        public LocationDTO $location
    ) {}
}
