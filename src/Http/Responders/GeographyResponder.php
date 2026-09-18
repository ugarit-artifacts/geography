<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Http\Responders;

use Heritage\Http\JsonResponse;
use Ugarit\Artifacts\Geography\Outcomes\GeographyOutcome;

class GeographyResponder
{
    public function toResponse(GeographyOutcome $outcome, int $status = 200): JsonResponse
    {
        return new JsonResponse(
            $outcome->toArray(),
            $outcome->successful ? $status : 422
        );
    }
}
