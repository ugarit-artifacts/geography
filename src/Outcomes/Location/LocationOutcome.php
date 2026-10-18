<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Outcomes\Location;

use Heritage\Actions\Action;
use Heritage\Outcomes\Outcome;
use Ugarit\Artifacts\Geography\Enums\Location\Capabilities\SaveLocationResult;
use Ugarit\Artifacts\Geography\Models\Location;

/**
 * The outcome of the Location capabilities.
 *
 * Supplies the Location placeholders of the feedback messages, naming the record from the data.
 */
readonly class LocationOutcome extends Outcome
{
    /**
     * The Location placeholders: model names, route base and the record carried by the outcome.
     *
     * @return array<string, mixed>
     */
    protected function defaultContext(): array
    {
        $subject = $this->subject();

        return [
            'model' => trans('geography::location.name'),
            'model_singular' => trans('geography::location.singular'),
            'model_plural' => trans('geography::location.plural'),
            'model_plural_definite' => trans('geography::location.plural_definite'),
            'routeBase' => 'location',
            'entity' => $subject instanceof Location ? $subject->getRouteKey() : null,
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

        if ($this->result !== SaveLocationResult::SUCCESS || ! $subject instanceof Location) {
            return parent::actions();
        }

        return [
            ...parent::actions(),
            Action::redirect(route('location.show', $subject), __('actions.view')),
        ];
    }
}
