<?php

namespace Ugarit\Artifacts\Geography\Policies\Location;

use Heritage\Contracts\Auth\Actor;
use Ugarit\Artifacts\Geography\Models\Location;

/**
 * Who may do what with Location records: the abilities its capabilities declare with #[Authorize].
 *
 * Every ability is granted until it is restricted here.
 */
class LocationPolicy
{
    /**
     * List Location records.
     *
     * @param  Actor  $actor
     * @return bool
     */
    public function viewAny(Actor $actor): bool
    {
        return true;
    }

    /**
     * View a Location.
     *
     * @param  Actor  $actor
     * @param  Location  $location
     * @return bool
     */
    public function view(Actor $actor, Location $location): bool
    {
        return true;
    }

    /**
     * Create a Location.
     *
     * @param  Actor  $actor
     * @return bool
     */
    public function create(Actor $actor): bool
    {
        return true;
    }

    /**
     * Update a Location.
     *
     * @param  Actor  $actor
     * @param  Location  $location
     * @return bool
     */
    public function update(Actor $actor, Location $location): bool
    {
        return true;
    }

    /**
     * Save a Location: create it, or update the given one.
     *
     * @param  Actor  $actor
     * @param  Location|null  $location
     * @return bool
     */
    public function save(Actor $actor, ?Location $location = null): bool
    {
        return $location === null ? $this->create($actor) : $this->update($actor, $location);
    }

    /**
     * Delete a Location.
     *
     * @param  Actor  $actor
     * @param  Location  $location
     * @return bool
     */
    public function delete(Actor $actor, Location $location): bool
    {
        return true;
    }

    /**
     * Restore a soft-deleted Location.
     *
     * @param  Actor  $actor
     * @param  Location  $location
     * @return bool
     */
    public function restore(Actor $actor, Location $location): bool
    {
        return true;
    }

    /**
     * Permanently delete a Location.
     *
     * @param  Actor  $actor
     * @param  Location  $location
     * @return bool
     */
    public function forceDelete(Actor $actor, Location $location): bool
    {
        return true;
    }

    /**
     * Add, edit or delete the translations of Location records.
     *
     * @param  Actor  $actor
     * @return bool
     */
    public function translate(Actor $actor): bool
    {
        return true;
    }
}
