<?php

namespace Ugarit\Artifacts\Geography\Policies\Governorate;

use Heritage\Contracts\Auth\Actor;
use Ugarit\Artifacts\Geography\Models\Governorate;

/**
 * Who may do what with Governorate records: the abilities its capabilities declare with #[Authorize].
 *
 * Every ability is granted until it is restricted here.
 */
class GovernoratePolicy
{
    /**
     * List Governorate records.
     *
     * @param  Actor  $actor
     * @return bool
     */
    public function viewAny(Actor $actor): bool
    {
        return true;
    }

    /**
     * View a Governorate.
     *
     * @param  Actor  $actor
     * @param  Governorate  $governorate
     * @return bool
     */
    public function view(Actor $actor, Governorate $governorate): bool
    {
        return true;
    }

    /**
     * Create a Governorate.
     *
     * @param  Actor  $actor
     * @return bool
     */
    public function create(Actor $actor): bool
    {
        return true;
    }

    /**
     * Update a Governorate.
     *
     * @param  Actor  $actor
     * @param  Governorate  $governorate
     * @return bool
     */
    public function update(Actor $actor, Governorate $governorate): bool
    {
        return true;
    }

    /**
     * Save a Governorate: create it, or update the given one.
     *
     * @param  Actor  $actor
     * @param  Governorate|null  $governorate
     * @return bool
     */
    public function save(Actor $actor, ?Governorate $governorate = null): bool
    {
        return $governorate === null ? $this->create($actor) : $this->update($actor, $governorate);
    }

    /**
     * Delete a Governorate.
     *
     * @param  Actor  $actor
     * @param  Governorate  $governorate
     * @return bool
     */
    public function delete(Actor $actor, Governorate $governorate): bool
    {
        return true;
    }

    /**
     * Restore a soft-deleted Governorate.
     *
     * @param  Actor  $actor
     * @param  Governorate  $governorate
     * @return bool
     */
    public function restore(Actor $actor, Governorate $governorate): bool
    {
        return true;
    }

    /**
     * Permanently delete a Governorate.
     *
     * @param  Actor  $actor
     * @param  Governorate  $governorate
     * @return bool
     */
    public function forceDelete(Actor $actor, Governorate $governorate): bool
    {
        return true;
    }

    /**
     * Add, edit or delete the translations of Governorate records.
     *
     * @param  Actor  $actor
     * @return bool
     */
    public function translate(Actor $actor): bool
    {
        return true;
    }
}
