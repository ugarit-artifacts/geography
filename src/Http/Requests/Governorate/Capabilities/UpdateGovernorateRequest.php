<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\Governorate\Capabilities;

use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Ugarit\Artifacts\Geography\Capabilities\Governorate\SaveGovernorateCapability;
use Ugarit\Artifacts\Geography\Rules\UniqueSlug;

/**
 * Validates payload for UpdateGovernorateRequest.
 */
#[ForAction(SaveGovernorateCapability::class)]
class UpdateGovernorateRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'country_id' => 'required|integer|exists:countries,id',
            'slug' => ['required', 'string', 'max:255', UniqueSlug::within('governorates', 'country_id', $this->input('country_id'), $this->route('governorate'))],
            'code' => 'nullable|string|max:255',
            'active' => 'required|boolean',
        ];
    }
}
