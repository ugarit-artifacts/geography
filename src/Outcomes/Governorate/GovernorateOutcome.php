<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Outcomes\Governorate;

use Heritage\Actions\Action;
use Heritage\Outcomes\Outcome;
use Ugarit\Artifacts\Geography\Enums\Governorate\Capabilities\SaveGovernorateResult;
use Ugarit\Artifacts\Geography\Models\Governorate;

/**
 * The outcome of the Governorate capabilities.
 *
 * Supplies the Governorate placeholders of the feedback messages, naming the record from the data.
 */
readonly class GovernorateOutcome extends Outcome
{
    /**
     * The Governorate placeholders: model names, route base and the record carried by the outcome.
     *
     * @return array<string, mixed>
     */
    protected function defaultContext(): array
    {
        $subject = $this->subject();

        return [
            'model' => trans('geography::governorate.name'),
            'model_singular' => trans('geography::governorate.singular'),
            'model_plural' => trans('geography::governorate.plural'),
            'model_plural_definite' => trans('geography::governorate.plural_definite'),
            'routeBase' => 'governorate',
            'entity' => $subject instanceof Governorate ? $subject->getRouteKey() : null,
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

        if ($this->result !== SaveGovernorateResult::SUCCESS || ! $subject instanceof Governorate) {
            return parent::actions();
        }

        return [
            ...parent::actions(),
            Action::redirect(route('governorate.show', $subject), __('actions.view')),
        ];
    }
}
