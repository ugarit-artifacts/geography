<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Services\UseCases;

use Ugarit\Artifacts\Geography\Contracts\LocationRepositoryContract;
use Ugarit\Artifacts\Geography\Outcomes\GeographyOutcome;

class IndexLocationsUseCase
{
    public function __construct(
        private readonly LocationRepositoryContract $repository
    ) {}

    public function handle(): GeographyOutcome
    {
        $locations = $this->repository->all();

        return GeographyOutcome::success(
            data: $locations->map(fn ($dto) => $dto->toArray())->all()
        );
    }
}
