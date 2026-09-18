<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\DTOs;

readonly class SaveLocationDTO
{
    public function __construct(
        public string $name,
        public ?int $cityId = null,
        public ?float $latitude = null,
        public ?float $longitude = null,
        public ?string $addressLine = null,
        public ?string $postalCode = null,
        public ?int $id = null,
    ) {}

    public static function fromArray(array $data, ?int $id = null): self
    {
        return new self(
            name: (string) $data['name'],
            cityId: isset($data['city_id']) ? (int) $data['city_id'] : null,
            latitude: isset($data['latitude']) ? (float) $data['latitude'] : null,
            longitude: isset($data['longitude']) ? (float) $data['longitude'] : null,
            addressLine: $data['address_line'] ?? null,
            postalCode: $data['postal_code'] ?? null,
            id: $id,
        );
    }

    public function toPersistenceArray(): array
    {
        return [
            'city_id' => $this->cityId,
            'name' => $this->name,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'address_line' => $this->addressLine,
            'postal_code' => $this->postalCode,
        ];
    }
}
