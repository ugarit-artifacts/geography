<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\City\Capabilities;

use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Heritage\Validation\Rule;
use Ugarit\Artifacts\Geography\Capabilities\City\DestroyCityCapability;
use Ugarit\Artifacts\Geography\Models\City;

/**
 * Validates the deletion of a city, confirmed by typing its slug.
 */
#[ForAction(DestroyCityCapability::class)]
class DestroyCityRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload: the typed confirmation must be the
     * slug of the city being deleted, and `force` deletes it permanently.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $city = $this->route('city');

        return [
            'confirmation' => [
                'required',
                'string',
                Rule::in($city instanceof City ? [(string) $city->slug] : []),
            ],
            'force' => 'sometimes|boolean',
        ];
    }
}
