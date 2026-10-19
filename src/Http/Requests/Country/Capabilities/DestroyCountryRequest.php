<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\Country\Capabilities;

use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Heritage\Validation\Rule;
use Ugarit\Artifacts\Geography\Capabilities\Country\DestroyCountryCapability;
use Ugarit\Artifacts\Geography\Models\Country;

/**
 * Validates the deletion of a country, confirmed by typing its id.
 */
#[ForAction(DestroyCountryCapability::class)]
class DestroyCountryRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload: the typed confirmation must be the
     * id of the country being deleted, and `force` deletes it permanently.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $country = $this->route('country');

        return [
            'confirmation' => [
                'required',
                'string',
                Rule::in($country instanceof Country ? [(string) $country->id] : []),
            ],
            'force' => 'sometimes|boolean',
        ];
    }
}
