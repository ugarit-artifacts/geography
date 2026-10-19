<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Rules;

use Heritage\Validation\Rule;
use Heritage\Validation\Rules\Unique;

/**
 * A slug that is unique among the live rows of one parent.
 */
final class UniqueSlug
{
    /**
     * @param  mixed  $parentId  The owning record. A missing parent fails this rule's sibling exists rule.
     * @param  mixed  $ignore  The current model, or its id, on update.
     */
    public static function within(string $table, string $parentColumn, mixed $parentId, mixed $ignore = null): Unique
    {
        $rule = Rule::unique($table, 'slug')->where($parentColumn, $parentId)->withoutTrashed();

        if ($ignore !== null && $ignore !== '') {
            $rule->ignore($ignore);
        }

        return $rule;
    }
}
