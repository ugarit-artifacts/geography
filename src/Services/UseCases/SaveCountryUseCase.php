<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Services\UseCases;

use Ugarit\Artifacts\Geography\Contracts\CountryRepositoryContract;
use Ugarit\Artifacts\Geography\DTOs\SaveCountryDTO;
use Ugarit\Artifacts\Geography\Outcomes\GeographyOutcome;
use Ugarit\Artifacts\Geography\Signals\CountryCreatedSignal;

class SaveCountryUseCase
{
    public function __construct(
        private readonly CountryRepositoryContract $repository
    ) {}

    public function handle(SaveCountryDTO $dto): GeographyOutcome
    {
        $saved = $this->repository->save($dto);

        event(new CountryCreatedSignal($saved));

        return GeographyOutcome::success(
            data: $saved->toArray(),
            message: "Country [{$saved->name}] saved successfully."
        );
    }
}
