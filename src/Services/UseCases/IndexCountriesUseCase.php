<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Services\UseCases;

use Ugarit\Artifacts\Geography\Contracts\CountryRepositoryContract;
use Ugarit\Artifacts\Geography\Outcomes\GeographyOutcome;

class IndexCountriesUseCase
{
    public function __construct(
        private readonly CountryRepositoryContract $repository
    ) {}

    public function handle(): GeographyOutcome
    {
        $countries = $this->repository->all();

        return GeographyOutcome::success(
            data: $countries->map(fn ($dto) => $dto->toArray())->all()
        );
    }
}
