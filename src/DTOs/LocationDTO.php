<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\DTOs;

readonly class LocationDTO
{
    public function __construct(
        public int $id,
        public ?int $cityId,
        public string $name,
        public ?float $latitude = null,
        public ?float $longitude = null,
        public ?string $addressLine = null,
        public ?string $postalCode = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            cityId: isset($data['city_id']) ? (int) $data['city_id'] : null,
            name: (string) $data['name'],
            latitude: isset($data['latitude']) ? (float) $data['latitude'] : null,
            longitude: isset($data['longitude']) ? (float) $data['longitude'] : null,
            addressLine: $data['address_line'] ?? null,
            postalCode: $data['postal_code'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'city_id' => $this->cityId,
            'name' => $this->name,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'address_line' => $this->addressLine,
            'postal_code' => $this->postalCode,
        ];
    }
}
