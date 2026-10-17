# Changelog

All notable changes to `ugarit-artifacts/geography` are documented here. Versions follow Ugarit numbering and match the git tags.

## [1.01.00] - 2026-10-17

* feat(countries): replace the country model shape with a translatable table.
* `countries` keeps `id`, `code`, `native_name`, `active`, `deleted_at`, `created_at`, and `updated_at`.
* `name` is created on `country_translations` by `Schema::createTranslatable()`, one row per locale.
* `Country` lists `name` as translatable, casts `active` to boolean, and exposes `governorates()`.

## [1.02.00] - 2026-10-17

* feat(governorates): add the translatable `governorates` table and align `Governorate`.
* Columns: `country_id` (restrict on delete), `slug`, optional `code`, `active`, soft deletes, and timestamps.
* `name` lives on `governorate_translations` and falls back to `slug`.
* Relations: `country()` and `cities()`.

## [1.03.00] - 2026-10-17

* feat(cities): add the translatable `cities` table and align `City`.
* Columns: `governorate_id` (restrict on delete), `slug`, optional `postal_code`, `active`, soft deletes, and timestamps.
* `name` lives on `city_translations` and falls back to `slug`.
* Relations: `governorate()`, `districts()`, and `locations()`.

## [1.04.00] - 2026-10-17

* feat(districts): add `districts` and `district_translations`, and the `District` model.
* Columns: `city_id` (restrict on delete), `slug`, optional `code`, optional `postal_code`, `active`, soft deletes, and timestamps.
* `name` is translatable and falls back to `slug`. `locations()` lists the locations of the district.
* `art.php` now publishes the `districts` capability and describes the artifact as countries, governorates, cities, districts, and addresses.

## [1.05.00] - 2026-10-17

* feat(locations): add the translatable `locations` table and align `Location`.
* `city_id` and `district_id` are nullable and use `ON DELETE SET NULL`.
* `latitude` is `decimal(10, 8)` and `longitude` is `decimal(11, 8)`, both nullable. `postal_code` is optional.
* `name` and `address_line` live on `location_translations` and fall back to `slug`.
* The model casts coordinates as `decimal:8` and exposes `city()` and `district()`.

<!-- releases -->
