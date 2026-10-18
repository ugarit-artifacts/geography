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

## [1.06.00] - 2026-10-17

* refactor(database)!: delete `2026_01_01_000010_create_geography_countries_table`, `..._000011_create_geography_governorates_table`, `..._000012_create_geography_cities_table`, and `..._000013_create_geography_locations_table`.
* Databases that already applied those migrations are not rewritten by this commit. New installs use the translatable tables added in 1.01.00â€“1.05.00.

## [1.07.00] - 2026-10-17

* feat(factories): add `CountryFactory`, `GovernorateFactory`, `CityFactory`, `DistrictFactory`, and `LocationFactory`.
* `CountryFactory` builds an ISO-sized code with `lexify` and uppercases it.
* `LocationFactory` creates the district first and sets `city_id` from that district, so the two foreign keys agree.
* Coordinates come from Faker latitude and longitude, inside the decimal ranges.

## [1.08.00] - 2026-10-17

* feat(seeders): add `CountrySeeder`, `GovernorateSeeder`, `CitySeeder`, `DistrictSeeder`, and `LocationSeeder`.
* Each seeder inserts the fixed `records()` list (still empty) and then ten factory rows, localized when the model is translatable.

## [1.09.00] - 2026-10-18

* feat(countries): add `CountryRepositoryInterface`, `CountryTranslationRepositoryInterface`, `CountryRepository`, and `CountryTranslationRepository`.
* The repository persists a parcel through `ModelRepository::save()` and returns the model.
* Remove `src/Repositories/CountryRepository.php`, which mapped rows to `CountryDTO`.

## [1.10.00] - 2026-10-18

* feat(countries): add the country capability parcels (index, create, show, edit, save, destroy) and the translation save and destroy parcels.
* Add `SaveCountryParcel` for the feature, including the `translations` payload keyed by locale code.
* Add `CountryOutcome` as the result envelope for country operations.

## [1.11.00] - 2026-10-18

* feat(countries): add `IndexCountriesCapability`, `CreateCountryCapability`, `ShowCountryCapability`, `EditCountryCapability`, `SaveCountryCapability`, and `DestroyCountryCapability`.
* Add `SaveCountryTranslationCapability` and `DestroyCountryTranslationCapability`.
* Each capability returns `CountryOutcome` from its result enum. `failed()` returns the failed result when `perform()` throws.
* `SaveCountryCapability` uppercases `code` before the repository writes it, so `ps` and `PS` are one value.

## [1.12.00] - 2026-10-18

* feat(countries): add `CountryPolicy` for the country authorization abilities used by `#[Authorize]` on the country capabilities.

## [1.13.00] - 2026-10-18

* feat(governorates): add `GovernorateRepository`, `GovernorateTranslationRepository`, and their contracts.
* Add governorate parcels for index, create, show, edit, save, destroy, translation save, translation destroy, and the save feature.
* Add `GovernorateOutcome`.
* Remove `src/Repositories/GovernorateRepository.php`.

<!-- releases -->
