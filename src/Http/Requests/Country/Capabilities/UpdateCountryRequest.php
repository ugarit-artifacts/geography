<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\Country\Capabilities;

use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Heritage\Validation\Rule;
use Ugarit\Artifacts\Geography\Capabilities\Country\SaveCountryCapability;
use Ugarit\Artifacts\Geography\Http\Requests\Country\UppercasesCountryCode;

/**
 * Validates payload for UpdateCountryRequest.
 */
#[ForAction(SaveCountryCapability::class)]
class UpdateCountryRequest extends FormRequest
{
    use UppercasesCountryCode;

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
        ];
    }
}
