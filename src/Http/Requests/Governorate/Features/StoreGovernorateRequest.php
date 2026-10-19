<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\Governorate\Features;

use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Ugarit\Artifacts\Geography\Features\Governorate\SaveGovernorateFeature;
use Ugarit\Artifacts\Geography\Rules\UniqueSlug;

/**
 * Validates payload for StoreGovernorateRequest.
 */
#[ForAction(SaveGovernorateFeature::class)]
class StoreGovernorateRequest extends FormRequest
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
            'country_id' => 'required|integer|exists:countries,id',
            'slug' => ['required', 'string', 'max:255', UniqueSlug::within('governorates', 'country_id', $this->input('country_id'))],
            'code' => 'nullable|string|max:255',
            'active' => 'required|boolean',
            'name' => 'required|string|min:2|max:64',
        ];
    }
}
