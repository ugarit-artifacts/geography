<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\District\Capabilities;

use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Heritage\Validation\Rule;
use Ugarit\Artifacts\Geography\Capabilities\District\DestroyDistrictCapability;
use Ugarit\Artifacts\Geography\Models\District;

/**
 * Validates the deletion of a district, confirmed by typing its slug.
 */
#[ForAction(DestroyDistrictCapability::class)]
class DestroyDistrictRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload: the typed confirmation must be the
     * slug of the district being deleted, and `force` deletes it permanently.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $district = $this->route('district');

        return [
            'confirmation' => [
                'required',
                'string',
                Rule::in($district instanceof District ? [(string) $district->slug] : []),
            ],
            'force' => 'sometimes|boolean',
        ];
    }
}
