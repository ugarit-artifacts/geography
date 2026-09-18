<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Services\UseCases;

use Ugarit\Artifacts\Geography\Contracts\GovernorateRepositoryContract;
use Ugarit\Artifacts\Geography\DTOs\SaveGovernorateDTO;
use Ugarit\Artifacts\Geography\Outcomes\GeographyOutcome;

class SaveGovernorateUseCase
{
    public function __construct(
        private readonly GovernorateRepositoryContract $repository
    ) {}

    public function handle(SaveGovernorateDTO $dto): GeographyOutcome
    {
        $saved = $this->repository->save($dto);

        return GeographyOutcome::success(
            data: $saved->toArray(),
            message: "Governorate [{$saved->name}] saved successfully."
        );
    }
}
