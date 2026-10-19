<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\Governorate\Capabilities\Translation;

use Heritage\Database\Eloquent\ModelTranslation;
use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Heritage\Validation\Rule;
use Ugarit\Artifacts\Geography\Capabilities\Governorate\Translation\DestroyGovernorateTranslationCapability;

/**
 * Validates the deletion of one Governorate translation, confirmed by typing its name.
 */
#[ForAction(DestroyGovernorateTranslationCapability::class)]
class DestroyGovernorateTranslationRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $translation = $this->route('governorate_translation');

        return [
            'name_confirmation' => [
                'required',
                'string',
                Rule::in($translation instanceof ModelTranslation ? [(string) $translation->name] : []),
            ],
        ];
    }
}
