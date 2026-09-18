<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\DTOs;

readonly class SaveCityDTO
{
    public function __construct(
        public int $governorateId,
        public string $name,
        public ?string $postalCode = null,
        public bool $isActive = true,
        public ?int $id = null,
    ) {}

    public static function fromArray(array $data, ?int $id = null): self
    {
        return new self(
            governorateId: (int) $data['governorate_id'],
            name: (string) $data['name'],
            postalCode: $data['postal_code'] ?? null,
            isActive: (bool) ($data['is_active'] ?? true),
            id: $id,
        );
    }

    public function toPersistenceArray(): array
    {
        return [
            'governorate_id' => $this->governorateId,
            'name' => $this->name,
            'postal_code' => $this->postalCode,
            'is_active' => $this->isActive,
        ];
    }
}
