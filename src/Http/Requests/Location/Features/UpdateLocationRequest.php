<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\Location\Features;

use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Ugarit\Artifacts\Geography\Features\Location\SaveLocationFeature;
use Ugarit\Artifacts\Geography\Http\Requests\Location\LocationRules;

/**
 * Validates payload for UpdateLocationRequest.
 */
#[ForAction(SaveLocationFeature::class)]
class UpdateLocationRequest extends FormRequest
{
    /**
     * Translatable attribute names to normalize and expand.
     *
     * @var array<int, string>
     */
    protected array $translatable = ['name', 'address_line'];

    /**
     * Validation rules applied to the incoming payload.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            ...LocationRules::attributes($this),
            'name' => 'required|string|min:2|max:64',
            'address_line' => 'required|string',
        ];
    }
}
