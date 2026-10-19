<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\District\Capabilities\Translation;

use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Ugarit\Artifacts\Geography\Capabilities\District\Translation\SaveDistrictTranslationCapability;

/**
 * Validates the update of one District translation; its locale does not change.
 */
#[ForAction(SaveDistrictTranslationCapability::class)]
class UpdateDistrictTranslationRequest extends FormRequest
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
