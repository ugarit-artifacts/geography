<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Outcomes\Country;

use Heritage\Actions\Action;
use Heritage\Outcomes\Outcome;
use Ugarit\Artifacts\Geography\Enums\Country\Capabilities\SaveCountryResult;
use Ugarit\Artifacts\Geography\Models\Country;

/**
 * The outcome of the Country capabilities.
 *
 * Supplies the Country placeholders of the feedback messages, naming the record from the data.
 */
readonly class CountryOutcome extends Outcome
{
    /**
     * The Country placeholders: model names, route base and the record carried by the outcome.
     *
     * @return array<string, mixed>
     */
    protected function defaultContext(): array
    {
        $subject = $this->subject();

        return [
            'model' => trans('geography::country.name'),
            'model_singular' => trans('geography::country.singular'),
            'model_plural' => trans('geography::country.plural'),
            'model_plural_definite' => trans('geography::country.plural_definite'),
            'routeBase' => 'country',
            'entity' => $subject instanceof Country ? $subject->getRouteKey() : null,
        ];
    }

    /**
     * Offer to view the record once it is saved.
     *
     * @return array<int, Action>
     */
    public function actions(): array
    {
        $subject = $this->subject();

        if ($this->result !== SaveCountryResult::SUCCESS || ! $subject instanceof Country) {
            return parent::actions();
        }

        return [
            ...parent::actions(),
            Action::redirect(route('country.show', $subject), __('actions.view')),
        ];
    }
}
