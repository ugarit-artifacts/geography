<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\City\Capabilities;

use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Ugarit\Artifacts\Geography\Capabilities\City\SaveCityCapability;
use Ugarit\Artifacts\Geography\Rules\UniqueSlug;

/**
 * Validates payload for UpdateCityRequest.
 */
#[ForAction(SaveCityCapability::class)]
class UpdateCityRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'governorate_id' => 'required|integer|exists:governorates,id',
            'slug' => ['required', 'string', 'max:255', UniqueSlug::within('cities', 'governorate_id', $this->input('governorate_id'), $this->route('city'))],
            'postal_code' => 'nullable|string|max:255',
            'active' => 'required|boolean',
        ];
    }
}
