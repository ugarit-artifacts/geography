<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\DTOs;

readonly class GovernorateDTO
{
    public function __construct(
        public int $id,
        public int $countryId,
        public string $name,
        public ?string $code = null,
        public bool $isActive = true,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            countryId: (int) $data['country_id'],
            name: (string) $data['name'],
            code: $data['code'] ?? null,
            isActive: (bool) ($data['is_active'] ?? true),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'country_id' => $this->countryId,
            'name' => $this->name,
            'code' => $this->code,
            'is_active' => $this->isActive,
        ];
    }
}
