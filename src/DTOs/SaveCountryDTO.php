<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\DTOs;

readonly class SaveCountryDTO
{
    public function __construct(
        public string $name,
        public string $isoAlpha2,
        public string $isoAlpha3,
        public ?string $dialCode = null,
        public ?string $currencyCode = null,
        public ?string $flagEmoji = null,
        public bool $isActive = true,
        public ?int $id = null,
    ) {}

    public static function fromArray(array $data, ?int $id = null): self
    {
        return new self(
            name: (string) $data['name'],
            isoAlpha2: (string) $data['iso_alpha_2'],
            isoAlpha3: (string) $data['iso_alpha_3'],
            dialCode: $data['dial_code'] ?? null,
            currencyCode: $data['currency_code'] ?? null,
            flagEmoji: $data['flag_emoji'] ?? null,
            isActive: (bool) ($data['is_active'] ?? true),
            id: $id,
        );
    }

    public function toPersistenceArray(): array
    {
        return [
            'name' => $this->name,
            'iso_alpha_2' => $this->isoAlpha2,
            'iso_alpha_3' => $this->isoAlpha3,
            'dial_code' => $this->dialCode,
            'currency_code' => $this->currencyCode,
            'flag_emoji' => $this->flagEmoji,
            'is_active' => $this->isActive,
        ];
    }
}
