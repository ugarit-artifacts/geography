<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\Governorate\Capabilities\Translation;

use Closure;
use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Heritage\Translation\Locales;
use Heritage\Validation\Rule;
use Ugarit\Artifacts\Geography\Capabilities\Governorate\Translation\SaveGovernorateTranslationCapability;
use Ugarit\Artifacts\Geography\Models\Governorate;

/**
 * Validates the translation of a Governorate for one locale, which it must not have yet.
 */
#[ForAction(SaveGovernorateTranslationCapability::class)]
class StoreGovernorateTranslationRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $governorate = $this->route('governorate');

        return [
            'locale' => [
                'required',
                'string',
                Rule::in(Locales::resolver()->available()),
                function (string $attribute, mixed $value, Closure $fail) use ($governorate) {
                    if ($governorate instanceof Governorate && $governorate->hasTranslation((string) $value)) {
                        $fail('validation.unique')->translate();
                    }
                },
            ],
            'name' => 'required|string|min:2|max:64',
        ];
    }
}
