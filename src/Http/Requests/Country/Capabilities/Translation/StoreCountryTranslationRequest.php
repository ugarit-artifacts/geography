<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\Country\Capabilities\Translation;

use Closure;
use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Heritage\Translation\Locales;
use Heritage\Validation\Rule;
use Ugarit\Artifacts\Geography\Capabilities\Country\Translation\SaveCountryTranslationCapability;
use Ugarit\Artifacts\Geography\Models\Country;

/**
 * Validates the translation of a Country for one locale, which it must not have yet.
 */
#[ForAction(SaveCountryTranslationCapability::class)]
class StoreCountryTranslationRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $country = $this->route('country');

        return [
            'locale' => [
                'required',
                'string',
                Rule::in(Locales::resolver()->available()),
                function (string $attribute, mixed $value, Closure $fail) use ($country) {
                    if ($country instanceof Country && $country->hasTranslation((string) $value)) {
                        $fail('validation.unique')->translate();
                    }
                },
            ],
            'name' => 'required|string|min:2|max:64',
        ];
    }
}
