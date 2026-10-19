<?php

namespace Ugarit\Artifacts\Geography\Http\Resources\Country\Translation;

use Heritage\Http\Request;
use Heritage\Http\Resources\Json\JsonResource;

/**
 * JSON resource representing one Country translation, its locale given as a code.
 */
class CountryTranslationResource extends JsonResource
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
            'country_id' => $this->country_id,
            'locale' => $this->locale_code,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
