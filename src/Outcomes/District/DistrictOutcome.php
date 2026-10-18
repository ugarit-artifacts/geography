<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Outcomes\District;

use Heritage\Actions\Action;
use Heritage\Outcomes\Outcome;
use Ugarit\Artifacts\Geography\Enums\District\Capabilities\SaveDistrictResult;
use Ugarit\Artifacts\Geography\Models\District;

/**
 * The outcome of the District capabilities.
 *
 * Supplies the District placeholders of the feedback messages, naming the record from the data.
 */
readonly class DistrictOutcome extends Outcome
{
    /**
     * The District placeholders: model names, route base and the record carried by the outcome.
     *
     * @return array<string, mixed>
     */
    protected function defaultContext(): array
    {
        $subject = $this->subject();

        return [
            'model' => trans('geography::district.name'),
            'model_singular' => trans('geography::district.singular'),
            'model_plural' => trans('geography::district.plural'),
            'model_plural_definite' => trans('geography::district.plural_definite'),
            'routeBase' => 'district',
            'entity' => $subject instanceof District ? $subject->getRouteKey() : null,
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

        if ($this->result !== SaveDistrictResult::SUCCESS || ! $subject instanceof District) {
            return parent::actions();
        }

        return [
            ...parent::actions(),
            Action::redirect(route('district.show', $subject), __('actions.view')),
        ];
    }
}
