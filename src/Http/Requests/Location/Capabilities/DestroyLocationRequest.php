<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\Location\Capabilities;

use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Heritage\Validation\Rule;
use Ugarit\Artifacts\Geography\Capabilities\Location\DestroyLocationCapability;
use Ugarit\Artifacts\Geography\Models\Location;

/**
 * Validates the deletion of a location, confirmed by typing its slug.
 */
#[ForAction(DestroyLocationCapability::class)]
class DestroyLocationRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload: the typed confirmation must be the
     * slug of the location being deleted, and `force` deletes it permanently.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $location = $this->route('location');

        return [
            'confirmation' => [
                'required',
                'string',
                Rule::in($location instanceof Location ? [(string) $location->slug] : []),
            ],
            'force' => 'sometimes|boolean',
        ];
    }
}
