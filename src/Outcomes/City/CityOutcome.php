<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Outcomes\City;

use Heritage\Actions\Action;
use Heritage\Outcomes\Outcome;
use Ugarit\Artifacts\Geography\Enums\City\Capabilities\SaveCityResult;
use Ugarit\Artifacts\Geography\Models\City;

/**
 * The outcome of the City capabilities.
 *
 * Supplies the City placeholders of the feedback messages, naming the record from the data.
 */
readonly class CityOutcome extends Outcome
{
    /**
     * The City placeholders: model names, route base and the record carried by the outcome.
     *
     * @return array<string, mixed>
     */
    protected function defaultContext(): array
    {
        $subject = $this->subject();

        return [
            'model' => trans('geography::city.name'),
            'model_singular' => trans('geography::city.singular'),
            'model_plural' => trans('geography::city.plural'),
            'model_plural_definite' => trans('geography::city.plural_definite'),
            'routeBase' => 'city',
            'entity' => $subject instanceof City ? $subject->getRouteKey() : null,
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

        if ($this->result !== SaveCityResult::SUCCESS || ! $subject instanceof City) {
            return parent::actions();
        }

        return [
            ...parent::actions(),
            Action::redirect(route('city.show', $subject), __('actions.view')),
        ];
    }
}
