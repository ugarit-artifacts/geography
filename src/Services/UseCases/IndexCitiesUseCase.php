<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Services\UseCases;

use Ugarit\Artifacts\Geography\Contracts\CityRepositoryContract;
use Ugarit\Artifacts\Geography\Outcomes\GeographyOutcome;

class IndexCitiesUseCase
{
    public function __construct(
        private readonly CityRepositoryContract $repository
    ) {}

    public function handle(int $governorateId): GeographyOutcome
    {
        $cities = $this->repository->getByGovernorate($governorateId);

        return GeographyOutcome::success(
            data: $cities->map(fn ($dto) => $dto->toArray())->all()
        );
    }
}
