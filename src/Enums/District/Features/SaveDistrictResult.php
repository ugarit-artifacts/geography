<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Enums\District\Features;

use Heritage\Contracts\Result\ResultContract;
use Heritage\Enums\Actions\Feedback\Variant;
use Heritage\Enums\Concerns\ResolvesResultFeedback;

/**
 * The results of SaveDistrictFeature, saving a district with its translations.
 *
 * Feedback is read from `responses.*` by convention: SUCCESS reads "saved",
 * SUCCESS_NO_TRANSLATION "saved_no_translation" and FAILED_X "failed_x".
 */
enum SaveDistrictResult: int implements ResultContract
{
    use ResolvesResultFeedback;

    /**
     * The base translation key of this result's feedback.
     */
    const FEEDBACK = 'saved';

    /**
     * The district and its translations were saved.
     */
    case SUCCESS = 1;

    /**
     * The district was saved, without translations in the payload.
     */
    case SUCCESS_NO_TRANSLATION = 2;

    /**
     * Saving the district's own columns failed.
     */
    case FAILED_MODEL_SAVE = 4;

    /**
     * Saving a translation failed.
     */
    case FAILED_TRANSLATION_SAVE = 5;

    /**
     * Deleting a translation sent as null failed.
     */
    case FAILED_TRANSLATION_DESTROY = 6;

    /**
     * An unspecified failure of the save.
     */
    case FAILED = 7;

    /**
     * An unspecified failure uses the generic failure message.
     *
     * @return string
     */
    protected function feedbackKey(): string
    {
        return match ($this) {
            self::FAILED => 'failed',
            default => $this->conventionalFeedbackKey(),
        };
    }

    /**
     * A save without translations is informational, not a full success.
     *
     * @return Variant
     */
    public function variant(): Variant
    {
        return match ($this) {
            self::SUCCESS_NO_TRANSLATION => Variant::INFO,
            default => $this->conventionalVariant(),
        };
    }
}
