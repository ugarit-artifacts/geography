<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\Location\Capabilities\Translation;

use Heritage\Database\Eloquent\ModelTranslation;
use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Heritage\Validation\Rule;
use Ugarit\Artifacts\Geography\Capabilities\Location\Translation\DestroyLocationTranslationCapability;

/**
 * Validates the deletion of one Location translation, confirmed by typing its name.
 */
#[ForAction(DestroyLocationTranslationCapability::class)]
class DestroyLocationTranslationRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $translation = $this->route('location_translation');

        return [
            'name_confirmation' => [
                'required',
                'string',
                Rule::in($translation instanceof ModelTranslation ? [(string) $translation->name] : []),
            ],
        ];
    }
}
