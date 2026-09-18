<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Repositories;

use Heritage\Support\Collection;
use Ugarit\Artifacts\Geography\Contracts\GovernorateRepositoryContract;
use Ugarit\Artifacts\Geography\DTOs\GovernorateDTO;
use Ugarit\Artifacts\Geography\DTOs\SaveGovernorateDTO;
use Ugarit\Artifacts\Geography\Models\Governorate;

class GovernorateRepository implements GovernorateRepositoryContract
{
    public function getByCountry(int $countryId): Collection
    {
        return Governorate::query()
            ->where('country_id', $countryId)
            ->orderBy('name', 'asc')
            ->get()
            ->map(fn (Governorate $m) => GovernorateDTO::fromArray($m->toArray()));
    }

    public function findById(int $id): ?GovernorateDTO
    {
        $m = Governorate::query()->find($id);

        return $m ? GovernorateDTO::fromArray($m->toArray()) : null;
    }

    public function save(SaveGovernorateDTO $dto): GovernorateDTO
    {
        $m = $dto->id ? Governorate::query()->findOrFail($dto->id) : new Governorate();
        $m->fill($dto->toPersistenceArray());
        $m->save();

        return GovernorateDTO::fromArray($m->toArray());
    }

    public function delete(int $id): bool
    {
        return (bool) Governorate::query()->where('id', $id)->delete();
    }
}
