<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Http\Requests\Location;

use Heritage\Foundation\Http\FormRequest;
use Heritage\Validation\Rule;
use Heritage\Validation\Rules\Exists;
use Heritage\Validation\Rules\Unique;
use Ugarit\Artifacts\Geography\Models\Location;

/**
 * Shared location rules: a district must belong to the given city, and a slug is unique
 * inside its district, or inside its city when no district is set.
 */
final class LocationRules
{
    /**
     * @return array<string, mixed>
     */
    public static function attributes(FormRequest $request): array
    {
        return [
            'city_id' => ['nullable', 'integer', Rule::exists('cities', 'id')->withoutTrashed()],
            'district_id' => ['nullable', 'integer', self::district($request)],
            'slug' => ['required', 'string', 'max:255', self::slug($request)],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'postal_code' => ['nullable', 'string', 'max:255'],
            'active' => ['required', 'boolean'],
        ];
    }

    /**
     * The district must exist, and must be a district of the city being saved.
     */
    protected static function district(FormRequest $request): Exists
    {
        $location = $request->route('location');
        $cityId = $request->exists('city_id')
            ? $request->input('city_id')
            : ($location instanceof Location ? $location->city_id : null);

        return Rule::exists('districts', 'id')->withoutTrashed()->where(function ($query) use ($cityId) {
            if ($cityId) {
                $query->where('city_id', $cityId);
            }
        });
    }

    /**
     * Unique among live locations that share this location's parent.
     */
    protected static function slug(FormRequest $request): Unique
    {
        $location = $request->route('location');
        $districtId = $request->exists('district_id')
            ? $request->input('district_id')
            : ($location instanceof Location ? $location->district_id : null);
        $cityId = $request->exists('city_id')
            ? $request->input('city_id')
            : ($location instanceof Location ? $location->city_id : null);

        $unique = Rule::unique('locations', 'slug')->withoutTrashed();

        if ($districtId) {
            $unique->where('district_id', $districtId);
        } elseif ($cityId) {
            $unique->where('city_id', $cityId)->whereNull('district_id');
        } else {
            $unique->whereNull('city_id')->whereNull('district_id');
        }

        if ($location instanceof Location) {
            $unique->ignore($location);
        }

        return $unique;
    }
}
