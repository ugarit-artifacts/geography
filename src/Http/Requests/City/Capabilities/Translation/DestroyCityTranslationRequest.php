<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\City\Capabilities\Translation;

use Heritage\Database\Eloquent\ModelTranslation;
use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Heritage\Validation\Rule;
use Ugarit\Artifacts\Geography\Capabilities\City\Translation\DestroyCityTranslationCapability;

/**
 * Validates the deletion of one City translation, confirmed by typing its name.
 */
#[ForAction(DestroyCityTranslationCapability::class)]
class DestroyCityTranslationRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $translation = $this->route('city_translation');

        return [
            'name_confirmation' => [
                'required',
                'string',
                Rule::in($translation instanceof ModelTranslation ? [(string) $translation->name] : []),
            ],
        ];
    }
}
