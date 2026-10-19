<?php

namespace Ugarit\Artifacts\Geography\Http\Resources\Country;

use Heritage\Http\Request;
use Heritage\Http\Resources\Json\JsonResource;

/**
 * JSON resource representing a Country.
 */
class CountryResource extends JsonResource
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
            'code' => $this->code,
            'native_name' => $this->native_name,
            'active' => $this->active,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'translations' => $this->whenLoaded('translations', fn () => (object) $this->translationsToArray()),
        ];
    }
}
