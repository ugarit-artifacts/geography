<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\Governorate\Capabilities\Translation;

use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Ugarit\Artifacts\Geography\Capabilities\Governorate\Translation\SaveGovernorateTranslationCapability;

/**
 * Validates the update of one Governorate translation; its locale does not change.
 */
#[ForAction(SaveGovernorateTranslationCapability::class)]
class UpdateGovernorateTranslationRequest extends FormRequest
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
