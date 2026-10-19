<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\City\Capabilities\Translation;

use Closure;
use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Heritage\Translation\Locales;
use Heritage\Validation\Rule;
use Ugarit\Artifacts\Geography\Capabilities\City\Translation\SaveCityTranslationCapability;
use Ugarit\Artifacts\Geography\Models\City;

/**
 * Validates the translation of a City for one locale, which it must not have yet.
 */
#[ForAction(SaveCityTranslationCapability::class)]
class StoreCityTranslationRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $city = $this->route('city');

        return [
            'locale' => [
                'required',
                'string',
                Rule::in(Locales::resolver()->available()),
                function (string $attribute, mixed $value, Closure $fail) use ($city) {
                    if ($city instanceof City && $city->hasTranslation((string) $value)) {
                        $fail('validation.unique')->translate();
                    }
                },
            ],
            'name' => 'required|string|min:2|max:64',
        ];
    }
}
