<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\Country\Capabilities\Translation;

use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Ugarit\Artifacts\Geography\Capabilities\Country\Translation\SaveCountryTranslationCapability;

/**
 * Validates the update of one Country translation; its locale does not change.
 */
#[ForAction(SaveCountryTranslationCapability::class)]
class UpdateCountryTranslationRequest extends FormRequest
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
