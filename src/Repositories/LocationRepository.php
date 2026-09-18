<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Repositories;

use Heritage\Support\Collection;
use Ugarit\Artifacts\Geography\Contracts\LocationRepositoryContract;
use Ugarit\Artifacts\Geography\DTOs\LocationDTO;
use Ugarit\Artifacts\Geography\DTOs\SaveLocationDTO;
use Ugarit\Artifacts\Geography\Models\Location;

class LocationRepository implements LocationRepositoryContract
{
    public function all(int $limit = 50): Collection
    {
        return Location::query()
            ->limit($limit)
            ->get()
            ->map(fn (Location $m) => LocationDTO::fromArray($m->toArray()));
    }

    public function findById(int $id): ?LocationDTO
    {
        $m = Location::query()->find($id);

        return $m ? LocationDTO::fromArray($m->toArray()) : null;
    }

    public function save(SaveLocationDTO $dto): LocationDTO
    {
        $m = $dto->id ? Location::query()->findOrFail($dto->id) : new Location();
        $m->fill($dto->toPersistenceArray());
        $m->save();

        return LocationDTO::fromArray($m->toArray());
    }

    public function delete(int $id): bool
    {
        return (bool) Location::query()->where('id', $id)->delete();
    }
}
