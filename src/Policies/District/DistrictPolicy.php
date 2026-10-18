<?php

namespace Ugarit\Artifacts\Geography\Policies\District;

use Heritage\Contracts\Auth\Actor;
use Ugarit\Artifacts\Geography\Models\District;

/**
 * Who may do what with District records: the abilities its capabilities declare with #[Authorize].
 *
 * Every ability is granted until it is restricted here.
 */
class DistrictPolicy
{
    /**
     * List District records.
     *
     * @param  Actor  $actor
     * @return bool
     */
    public function viewAny(Actor $actor): bool
    {
        return true;
    }

    /**
     * View a District.
     *
     * @param  Actor  $actor
     * @param  District  $district
     * @return bool
     */
    public function view(Actor $actor, District $district): bool
    {
        return true;
    }

    /**
     * Create a District.
     *
     * @param  Actor  $actor
     * @return bool
     */
    public function create(Actor $actor): bool
    {
        return true;
    }

    /**
     * Update a District.
     *
     * @param  Actor  $actor
     * @param  District  $district
     * @return bool
     */
    public function update(Actor $actor, District $district): bool
    {
        return true;
    }

    /**
     * Save a District: create it, or update the given one.
     *
     * @param  Actor  $actor
     * @param  District|null  $district
     * @return bool
     */
    public function save(Actor $actor, ?District $district = null): bool
    {
        return $district === null ? $this->create($actor) : $this->update($actor, $district);
    }

    /**
     * Delete a District.
     *
     * @param  Actor  $actor
     * @param  District  $district
     * @return bool
     */
    public function delete(Actor $actor, District $district): bool
    {
        return true;
    }

    /**
     * Restore a soft-deleted District.
     *
     * @param  Actor  $actor
     * @param  District  $district
     * @return bool
     */
    public function restore(Actor $actor, District $district): bool
    {
        return true;
    }

    /**
     * Permanently delete a District.
     *
     * @param  Actor  $actor
     * @param  District  $district
     * @return bool
     */
    public function forceDelete(Actor $actor, District $district): bool
    {
        return true;
    }

    /**
     * Add, edit or delete the translations of District records.
     *
     * @param  Actor  $actor
     * @return bool
     */
    public function translate(Actor $actor): bool
    {
        return true;
    }
}
