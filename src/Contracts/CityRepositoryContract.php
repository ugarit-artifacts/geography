<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Contracts;

use Heritage\Support\Collection;
use Ugarit\Artifacts\Geography\DTOs\CityDTO;
use Ugarit\Artifacts\Geography\DTOs\SaveCityDTO;

interface CityRepositoryContract
{
    /**
     * @return Collection<int, CityDTO>
     */
    public function getByGovernorate(int $governorateId): Collection;

    public function findById(int $id): ?CityDTO;

    public function save(SaveCityDTO $dto): CityDTO;

    public function delete(int $id): bool;
}
