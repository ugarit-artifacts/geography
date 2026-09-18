<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Contracts;

use Heritage\Support\Collection;
use Ugarit\Artifacts\Geography\DTOs\GovernorateDTO;
use Ugarit\Artifacts\Geography\DTOs\SaveGovernorateDTO;

interface GovernorateRepositoryContract
{
    /**
     * @return Collection<int, GovernorateDTO>
     */
    public function getByCountry(int $countryId): Collection;

    public function findById(int $id): ?GovernorateDTO;

    public function save(SaveGovernorateDTO $dto): GovernorateDTO;

    public function delete(int $id): bool;
}
