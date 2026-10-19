<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\District\Capabilities;

use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Ugarit\Artifacts\Geography\Capabilities\District\SaveDistrictCapability;
use Ugarit\Artifacts\Geography\Rules\UniqueSlug;

/**
 * Validates payload for StoreDistrictRequest.
 */
#[ForAction(SaveDistrictCapability::class)]
class StoreDistrictRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'city_id' => 'required|integer|exists:cities,id',
            'slug' => ['required', 'string', 'max:255', UniqueSlug::within('districts', 'city_id', $this->input('city_id'))],
            'code' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'active' => 'required|boolean',
        ];
    }
}
