<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\City\Features;

use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Ugarit\Artifacts\Geography\Features\City\SaveCityFeature;
use Ugarit\Artifacts\Geography\Rules\UniqueSlug;

/**
 * Validates payload for UpdateCityRequest.
 */
#[ForAction(SaveCityFeature::class)]
class UpdateCityRequest extends FormRequest
{
    /**
     * Translatable attribute names to normalize and expand.
     *
     * @var array<int, string>
     */
    protected array $translatable = ['name'];

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
            'name' => 'required|string|min:2|max:64',
        ];
    }
}
