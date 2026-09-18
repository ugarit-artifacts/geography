<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Services\UseCases;

use Ugarit\Artifacts\Geography\Contracts\GovernorateRepositoryContract;
use Ugarit\Artifacts\Geography\Outcomes\GeographyOutcome;

class IndexGovernoratesUseCase
{
    public function __construct(
        private readonly GovernorateRepositoryContract $repository
    ) {}

    public function handle(int $countryId): GeographyOutcome
    {
        $governorates = $this->repository->getByCountry($countryId);

        return GeographyOutcome::success(
            data: $governorates->map(fn ($dto) => $dto->toArray())->all()
        );
    }
}
