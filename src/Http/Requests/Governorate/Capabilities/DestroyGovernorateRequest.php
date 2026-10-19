<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\Governorate\Capabilities;

use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Heritage\Validation\Rule;
use Ugarit\Artifacts\Geography\Capabilities\Governorate\DestroyGovernorateCapability;
use Ugarit\Artifacts\Geography\Models\Governorate;

/**
 * Validates the deletion of a governorate, confirmed by typing its slug.
 */
#[ForAction(DestroyGovernorateCapability::class)]
class DestroyGovernorateRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload: the typed confirmation must be the
     * slug of the governorate being deleted, and `force` deletes it permanently.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $governorate = $this->route('governorate');

        return [
            'confirmation' => [
                'required',
                'string',
                Rule::in($governorate instanceof Governorate ? [(string) $governorate->slug] : []),
            ],
            'force' => 'sometimes|boolean',
        ];
    }
}
