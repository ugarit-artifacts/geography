<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Services\UseCases;

use Ugarit\Artifacts\Geography\Contracts\LocationRepositoryContract;
use Ugarit\Artifacts\Geography\DTOs\SaveLocationDTO;
use Ugarit\Artifacts\Geography\Outcomes\GeographyOutcome;
use Ugarit\Artifacts\Geography\Signals\LocationCreatedSignal;

class SaveLocationUseCase
{
    public function __construct(
        private readonly LocationRepositoryContract $repository
    ) {}

    public function handle(SaveLocationDTO $dto): GeographyOutcome
    {
        $saved = $this->repository->save($dto);

        event(new LocationCreatedSignal($saved));

        return GeographyOutcome::success(
            data: $saved->toArray(),
            message: "Location [{$saved->name}] saved successfully."
        );
    }
}
