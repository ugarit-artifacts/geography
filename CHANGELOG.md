# Changelog

All notable changes to `ugarit-artifacts/geography` are documented here. Versions follow Ugarit numbering and match the git tags.

## [1.01.00] - 2026-10-17

* feat(countries): replace the country model shape with a translatable table.
* `countries` keeps `id`, `code`, `native_name`, `active`, `deleted_at`, `created_at`, and `updated_at`.
* `name` is created on `country_translations` by `Schema::createTranslatable()`, one row per locale.
* `Country` lists `name` as translatable, casts `active` to boolean, and exposes `governorates()`.

<!-- releases -->
