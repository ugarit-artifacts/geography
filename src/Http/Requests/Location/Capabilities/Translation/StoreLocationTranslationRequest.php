<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\Location\Capabilities\Translation;

use Closure;
use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Heritage\Translation\Locales;
use Heritage\Validation\Rule;
use Ugarit\Artifacts\Geography\Capabilities\Location\Translation\SaveLocationTranslationCapability;
use Ugarit\Artifacts\Geography\Models\Location;

/**
 * Validates the translation of a Location for one locale, which it must not have yet.
 */
#[ForAction(SaveLocationTranslationCapability::class)]
class StoreLocationTranslationRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $location = $this->route('location');

        return [
            'locale' => [
                'required',
                'string',
                Rule::in(Locales::resolver()->available()),
                function (string $attribute, mixed $value, Closure $fail) use ($location) {
                    if ($location instanceof Location && $location->hasTranslation((string) $value)) {
                        $fail('validation.unique')->translate();
                    }
                },
            ],
            'name' => 'required|string|min:2|max:64',
            'address_line' => 'required|string',
        ];
    }
}
