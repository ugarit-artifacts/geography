<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Contracts;

use Heritage\Support\Collection;
use Ugarit\Artifacts\Geography\DTOs\LocationDTO;
use Ugarit\Artifacts\Geography\DTOs\SaveLocationDTO;

interface LocationRepositoryContract
{
    /**
     * @return Collection<int, LocationDTO>
     */
    public function all(int $limit = 50): Collection;

    public function findById(int $id): ?LocationDTO;

    public function save(SaveLocationDTO $dto): LocationDTO;

    public function delete(int $id): bool;
}
