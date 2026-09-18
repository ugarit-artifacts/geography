<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Contracts;

use Heritage\Support\Collection;
use Ugarit\Artifacts\Geography\DTOs\CountryDTO;
use Ugarit\Artifacts\Geography\DTOs\SaveCountryDTO;

interface CountryRepositoryContract
{
    /**
     * @return Collection<int, CountryDTO>
     */
    public function all(): Collection;

    public function findById(int $id): ?CountryDTO;

    public function findByIso(string $iso): ?CountryDTO;

    public function save(SaveCountryDTO $dto): CountryDTO;

    public function delete(int $id): bool;
}
