<?php

namespace Ugarit\Artifacts\Geography\Http\Resources\Location\Translation;

use Heritage\Http\Request;
use Heritage\Http\Resources\Json\JsonResource;

/**
 * JSON resource representing one Location translation, its locale given as a code.
 */
class LocationTranslationResource extends JsonResource
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
            'location_id' => $this->location_id,
            'locale' => $this->locale_code,
            'name' => $this->name,
            'address_line' => $this->address_line,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
