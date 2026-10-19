<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\Country\Features;

use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Heritage\Validation\Rule;
use Ugarit\Artifacts\Geography\Features\Country\SaveCountryFeature;
use Ugarit\Artifacts\Geography\Http\Requests\Country\UppercasesCountryCode;

/**
 * Validates payload for UpdateCountryRequest.
 */
#[ForAction(SaveCountryFeature::class)]
class UpdateCountryRequest extends FormRequest
{
    use UppercasesCountryCode;

    /**
     * Translatable attribute names to normalize and expand.
     *
     * @var array<int, string>
     */
    protected array $translatable = ['name'];

    /**
     * Validation rules applied to the incoming payload.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'size:2', 'regex:/^[A-Za-z]{2}$/', Rule::unique('countries', 'code')->withoutTrashed()->ignore($this->route('country'))],
            'native_name' => 'required|string|max:255',
            'active' => 'required|boolean',
            'name' => 'required|string|min:2|max:64',
        ];
    }
}
