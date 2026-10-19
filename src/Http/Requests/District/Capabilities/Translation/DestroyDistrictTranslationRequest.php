<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\District\Capabilities\Translation;

use Heritage\Database\Eloquent\ModelTranslation;
use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Heritage\Validation\Rule;
use Ugarit\Artifacts\Geography\Capabilities\District\Translation\DestroyDistrictTranslationCapability;

/**
 * Validates the deletion of one District translation, confirmed by typing its name.
 */
#[ForAction(DestroyDistrictTranslationCapability::class)]
class DestroyDistrictTranslationRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $translation = $this->route('district_translation');

        return [
            'name_confirmation' => [
                'required',
                'string',
                Rule::in($translation instanceof ModelTranslation ? [(string) $translation->name] : []),
            ],
        ];
    }
}
