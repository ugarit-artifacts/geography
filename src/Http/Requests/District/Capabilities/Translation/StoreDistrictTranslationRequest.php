<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\District\Capabilities\Translation;

use Closure;
use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Heritage\Translation\Locales;
use Heritage\Validation\Rule;
use Ugarit\Artifacts\Geography\Capabilities\District\Translation\SaveDistrictTranslationCapability;
use Ugarit\Artifacts\Geography\Models\District;

/**
 * Validates the translation of a District for one locale, which it must not have yet.
 */
#[ForAction(SaveDistrictTranslationCapability::class)]
class StoreDistrictTranslationRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $district = $this->route('district');

        return [
            'locale' => [
                'required',
                'string',
                Rule::in(Locales::resolver()->available()),
                function (string $attribute, mixed $value, Closure $fail) use ($district) {
                    if ($district instanceof District && $district->hasTranslation((string) $value)) {
                        $fail('validation.unique')->translate();
                    }
                },
            ],
            'name' => 'required|string|min:2|max:64',
        ];
    }
}
