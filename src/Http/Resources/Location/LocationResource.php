<?php

namespace Ugarit\Artifacts\Geography\Http\Resources\Location;

use Heritage\Http\Request;
use Heritage\Http\Resources\Json\JsonResource;

/**
 * JSON resource representing a Location.
 */
class LocationResource extends JsonResource
{
    /**
     * Disable the default "data" wrapper for this resource.
     *
     * @var string|null
     */
    public static $wrap = null;

    /**
     * Transform the resource into its API array representation.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'city_id' => $this->city_id,
            'district_id' => $this->district_id,
            'slug' => $this->slug,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'postal_code' => $this->postal_code,
            'active' => $this->active,
            'name' => $this->name,
            'address_line' => $this->address_line,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'translations' => $this->whenLoaded('translations', fn () => (object) $this->translationsToArray()),
        ];
    }
}
