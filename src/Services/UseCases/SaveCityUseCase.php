<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Services\UseCases;

use Ugarit\Artifacts\Geography\Contracts\CityRepositoryContract;
use Ugarit\Artifacts\Geography\DTOs\SaveCityDTO;
use Ugarit\Artifacts\Geography\Outcomes\GeographyOutcome;

class SaveCityUseCase
{
    public function __construct(
        private readonly CityRepositoryContract $repository
    ) {}

    public function handle(SaveCityDTO $dto): GeographyOutcome
    {
        $saved = $this->repository->save($dto);

        return GeographyOutcome::success(
            data: $saved->toArray(),
            message: "City [{$saved->name}] saved successfully."
        );
    }
}
