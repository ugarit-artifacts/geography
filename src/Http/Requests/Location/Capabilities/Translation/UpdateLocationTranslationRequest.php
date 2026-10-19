<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\Location\Capabilities\Translation;

use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Ugarit\Artifacts\Geography\Capabilities\Location\Translation\SaveLocationTranslationCapability;

/**
 * Validates the update of one Location translation; its locale does not change.
 */
#[ForAction(SaveLocationTranslationCapability::class)]
class UpdateLocationTranslationRequest extends FormRequest
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
            'address_line' => 'required|string',
        ];
    }
}
