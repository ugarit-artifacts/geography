<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\Country\Capabilities\Translation;

use Heritage\Database\Eloquent\ModelTranslation;
use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Heritage\Validation\Rule;
use Ugarit\Artifacts\Geography\Capabilities\Country\Translation\DestroyCountryTranslationCapability;

/**
 * Validates the deletion of one Country translation, confirmed by typing its name.
 */
#[ForAction(DestroyCountryTranslationCapability::class)]
class DestroyCountryTranslationRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $translation = $this->route('country_translation');

        return [
            'name_confirmation' => [
                'required',
                'string',
                Rule::in($translation instanceof ModelTranslation ? [(string) $translation->name] : []),
            ],
        ];
    }
}
