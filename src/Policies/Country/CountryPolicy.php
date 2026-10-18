<?php

namespace Ugarit\Artifacts\Geography\Policies\Country;

use Heritage\Contracts\Auth\Actor;
use Ugarit\Artifacts\Geography\Models\Country;

/**
 * Who may do what with Country records: the abilities its capabilities declare with #[Authorize].
 *
 * Every ability is granted until it is restricted here.
 */
class CountryPolicy
{
    /**
     * List Country records.
     *
     * @param  Actor  $actor
     * @return bool
     */
    public function viewAny(Actor $actor): bool
    {
        return true;
    }

    /**
     * View a Country.
     *
     * @param  Actor  $actor
     * @param  Country  $country
     * @return bool
     */
    public function view(Actor $actor, Country $country): bool
    {
        return true;
    }

    /**
     * Create a Country.
     *
     * @param  Actor  $actor
     * @return bool
     */
    public function create(Actor $actor): bool
    {
        return true;
    }

    /**
     * Update a Country.
     *
     * @param  Actor  $actor
     * @param  Country  $country
     * @return bool
     */
    public function update(Actor $actor, Country $country): bool
    {
        return true;
    }

    /**
     * Save a Country: create it, or update the given one.
     *
     * @param  Actor  $actor
     * @param  Country|null  $country
     * @return bool
     */
    public function save(Actor $actor, ?Country $country = null): bool
    {
        return $country === null ? $this->create($actor) : $this->update($actor, $country);
    }

    /**
     * Delete a Country.
     *
     * @param  Actor  $actor
     * @param  Country  $country
     * @return bool
     */
    public function delete(Actor $actor, Country $country): bool
    {
        return true;
    }

    /**
     * Restore a soft-deleted Country.
     *
     * @param  Actor  $actor
     * @param  Country  $country
     * @return bool
     */
    public function restore(Actor $actor, Country $country): bool
    {
        return true;
    }

    /**
     * Permanently delete a Country.
     *
     * @param  Actor  $actor
     * @param  Country  $country
     * @return bool
     */
    public function forceDelete(Actor $actor, Country $country): bool
    {
        return true;
    }

    /**
     * Add, edit or delete the translations of Country records.
     *
     * @param  Actor  $actor
     * @return bool
     */
    public function translate(Actor $actor): bool
    {
        return true;
    }
}
