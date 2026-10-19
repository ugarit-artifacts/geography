<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\City\Capabilities\Translation;

use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Ugarit\Artifacts\Geography\Capabilities\City\Translation\SaveCityTranslationCapability;

/**
 * Validates the update of one City translation; its locale does not change.
 */
#[ForAction(SaveCityTranslationCapability::class)]
class UpdateCityTranslationRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:64',
        ];
    }
}
