<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Enums\Country\Capabilities\Translation;

use Heritage\Contracts\Result\ResultContract;
use Heritage\Enums\Concerns\ResolvesResultFeedback;

/**
 * Enum DestroyCountryTranslationResult
 *
 * The results of an action. Feedback is read from `responses.*` by convention, within the
 * group of FEEDBACK (e.g. "translation.saved" reads under `responses.translation.`):
 * SUCCESS reads the FEEDBACK key, SUCCESS_X "{action}_x", FAILED "failed_{action}" and
 * FAILED_X "failed_x". Success cases answer 200, failures 400; override feedbackKey(),
 * feedbackContext(), variant() or statusCode() per case.
 */
enum DestroyCountryTranslationResult: int implements ResultContract
{
    use ResolvesResultFeedback;

    /**
     * The base translation key of this result's feedback.
     */
    const FEEDBACK = 'translation.deleted';

    /**
     * Destroy country translation succeeded; its feedback reads `responses.translation.deleted`.
     */
    case SUCCESS = 1;

    /**
     * Destroy country translation failed; its feedback reads `responses.translation.failed_deleted`.
     */
    case FAILED = 2;
}
