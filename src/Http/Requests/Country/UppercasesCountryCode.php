<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Http\Requests\Country;

/**
 * Stores an ISO 3166-1 alpha-2 code in uppercase before the unique check runs.
 */
trait UppercasesCountryCode
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (is_string($this->input('code'))) {
            $this->merge(['code' => strtoupper($this->input('code'))]);
        }

        parent::prepareForValidation();
    }
}
