<?php

namespace Ugarit\Artifacts\Geography\Http\Requests\Location\Capabilities;

use Heritage\Foundation\Http\Attributes\ForAction;
use Heritage\Foundation\Http\FormRequest;
use Ugarit\Artifacts\Geography\Capabilities\Location\SaveLocationCapability;
use Ugarit\Artifacts\Geography\Http\Requests\Location\LocationRules;

/**
 * Validates payload for UpdateLocationRequest.
 */
#[ForAction(SaveLocationCapability::class)]
class UpdateLocationRequest extends FormRequest
{
    /**
     * Validation rules applied to the incoming payload.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return LocationRules::attributes($this);
    }
}
