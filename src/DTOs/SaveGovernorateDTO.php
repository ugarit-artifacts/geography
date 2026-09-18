<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\DTOs;

readonly class SaveGovernorateDTO
{
    public function __construct(
        public int $countryId,
        public string $name,
        public ?string $code = null,
        public bool $isActive = true,
        public ?int $id = null,
    ) {}

    public static function fromArray(array $data, ?int $id = null): self
    {
        return new self(
            countryId: (int) $data['country_id'],
            name: (string) $data['name'],
            code: $data['code'] ?? null,
            isActive: (bool) ($data['is_active'] ?? true),
            id: $id,
        );
    }

    public function toPersistenceArray(): array
    {
        return [
            'country_id' => $this->countryId,
            'name' => $this->name,
            'code' => $this->code,
            'is_active' => $this->isActive,
        ];
    }
}
