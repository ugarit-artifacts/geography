<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\DTOs;

readonly class CityDTO
{
    public function __construct(
        public int $id,
        public int $governorateId,
        public string $name,
        public ?string $postalCode = null,
        public bool $isActive = true,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            governorateId: (int) $data['governorate_id'],
            name: (string) $data['name'],
            postalCode: $data['postal_code'] ?? null,
            isActive: (bool) ($data['is_active'] ?? true),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'governorate_id' => $this->governorateId,
            'name' => $this->name,
            'postal_code' => $this->postalCode,
            'is_active' => $this->isActive,
        ];
    }
}
