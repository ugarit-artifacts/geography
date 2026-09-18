<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Repositories;

use Heritage\Support\Collection;
use Ugarit\Artifacts\Geography\Contracts\CityRepositoryContract;
use Ugarit\Artifacts\Geography\DTOs\CityDTO;
use Ugarit\Artifacts\Geography\DTOs\SaveCityDTO;
use Ugarit\Artifacts\Geography\Models\City;

class CityRepository implements CityRepositoryContract
{
    public function getByGovernorate(int $governorateId): Collection
    {
        return City::query()
            ->where('governorate_id', $governorateId)
            ->orderBy('name', 'asc')
            ->get()
            ->map(fn (City $m) => CityDTO::fromArray($m->toArray()));
    }

    public function findById(int $id): ?CityDTO
    {
        $m = City::query()->find($id);

        return $m ? CityDTO::fromArray($m->toArray()) : null;
    }

    public function save(SaveCityDTO $dto): CityDTO
    {
        $m = $dto->id ? City::query()->findOrFail($dto->id) : new City();
        $m->fill($dto->toPersistenceArray());
        $m->save();

        return CityDTO::fromArray($m->toArray());
    }

    public function delete(int $id): bool
    {
        return (bool) City::query()->where('id', $id)->delete();
    }
}
