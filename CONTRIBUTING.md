# Contributing to Ugarit Geography Artifact

Thank you for contributing to `ugarit-artifacts/geography`.

## Scope

Changes here are the territorial registry: the five entities, their translation tables, capabilities, and the save features. Locale storage belongs to `ugarit-artifacts/i18n`. Do not copy framework types out of `Heritage\`.

A new column follows the schema in [SCHEMA.md](SCHEMA.md):

* A value that changes per locale is `->translatable()` inside `Schema::createTranslatable()` (or `Schema::tableTranslatable()` on an existing table) and is listed on the model's `$translatable`.
* A stable identifier stays on the main table (`code` or `slug`) and is unique there.
* A parent link uses `foreignId()->constrained()`, and `nullOnDelete()` only when the child may outlive the parent, as locations do.

## Standards

* Conventional Commits: `feat(districts): store an optional postal code`.
* Format with `vendor/bin/pint`.
* Run `php scribe test` from the host application before opening a pull request.

## Pull requests

One logical change per pull request. Say which tables move, and update [SCHEMA.md](SCHEMA.md) in the same change when a migration adds, drops, or retypes a column.
