<?php

namespace Ugarit\Artifacts\Geography\Policies\City;

use Heritage\Contracts\Auth\Actor;
use Ugarit\Artifacts\Geography\Models\City;

/**
 * Who may do what with City records: the abilities its capabilities declare with #[Authorize].
 *
 * Every ability is granted until it is restricted here.
 */
class CityPolicy
{
    /**
     * List City records.
     *
     * @param  Actor  $actor
     * @return bool
     */
    public function viewAny(Actor $actor): bool
    {
        return true;
    }

    /**
     * View a City.
     *
     * @param  Actor  $actor
     * @param  City  $city
     * @return bool
     */
    public function view(Actor $actor, City $city): bool
    {
        return true;
    }

    /**
     * Create a City.
     *
     * @param  Actor  $actor
     * @return bool
     */
    public function create(Actor $actor): bool
    {
        return true;
    }

    /**
     * Update a City.
     *
     * @param  Actor  $actor
     * @param  City  $city
     * @return bool
     */
    public function update(Actor $actor, City $city): bool
    {
        return true;
    }

    /**
     * Save a City: create it, or update the given one.
     *
     * @param  Actor  $actor
     * @param  City|null  $city
     * @return bool
     */
    public function save(Actor $actor, ?City $city = null): bool
    {
        return $city === null ? $this->create($actor) : $this->update($actor, $city);
    }

    /**
     * Delete a City.
     *
     * @param  Actor  $actor
     * @param  City  $city
     * @return bool
     */
    public function delete(Actor $actor, City $city): bool
    {
        return true;
    }

    /**
     * Restore a soft-deleted City.
     *
     * @param  Actor  $actor
     * @param  City  $city
     * @return bool
     */
    public function restore(Actor $actor, City $city): bool
    {
        return true;
    }

    /**
     * Permanently delete a City.
     *
     * @param  Actor  $actor
     * @param  City  $city
     * @return bool
     */
    public function forceDelete(Actor $actor, City $city): bool
    {
        return true;
    }

    /**
     * Add, edit or delete the translations of City records.
     *
     * @param  Actor  $actor
     * @return bool
     */
    public function translate(Actor $actor): bool
    {
        return true;
    }
}
