<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Repositories;

use Heritage\Support\Collection;
use Ugarit\Artifacts\Geography\Contracts\CountryRepositoryContract;
use Ugarit\Artifacts\Geography\DTOs\CountryDTO;
use Ugarit\Artifacts\Geography\DTOs\SaveCountryDTO;
use Ugarit\Artifacts\Geography\Models\Country;

class CountryRepository implements CountryRepositoryContract
{
    public function all(): Collection
    {
        return Country::query()
            ->orderBy('name', 'asc')
            ->get()
            ->map(fn (Country $m) => CountryDTO::fromArray($m->toArray()));
    }

    public function findById(int $id): ?CountryDTO
    {
        $m = Country::query()->find($id);

        return $m ? CountryDTO::fromArray($m->toArray()) : null;
    }

    public function findByIso(string $iso): ?CountryDTO
    {
        $m = Country::query()
            ->where('iso_alpha_2', strtoupper($iso))
            ->orWhere('iso_alpha_3', strtoupper($iso))
            ->first();

        return $m ? CountryDTO::fromArray($m->toArray()) : null;
    }

    public function save(SaveCountryDTO $dto): CountryDTO
    {
        $m = $dto->id ? Country::query()->findOrFail($dto->id) : new Country();
        $m->fill($dto->toPersistenceArray());
        $m->save();

        return CountryDTO::fromArray($m->toArray());
    }

    public function delete(int $id): bool
    {
        return (bool) Country::query()->where('id', $id)->delete();
    }
}
