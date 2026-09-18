<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Services\UseCases;

use Ugarit\Artifacts\Geography\Contracts\CountryRepositoryContract;
use Ugarit\Artifacts\Geography\Outcomes\GeographyOutcome;

class ShowCountryUseCase
{
    public function __construct(
        private readonly CountryRepositoryContract $repository
    ) {}

    public function handle(string $iso): GeographyOutcome
    {
        $country = $this->repository->findByIso($iso);

        if (! $country) {
            return GeographyOutcome::failure("Country [{$iso}] not found.");
        }

        return GeographyOutcome::success(data: $country->toArray());
    }
}
