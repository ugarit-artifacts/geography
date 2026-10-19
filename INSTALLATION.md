# Installation

Integrate `ugarit-artifacts/geography` into a host Ugarit application. The package does not boot by itself.

## Requirements

| Requirement | Notes |
| :--- | :--- |
| **PHP** | ^8.3 |
| **`ugarit/framework`** | ^1.00.00 |
| **`ugarit-artifacts/i18n`** | Required capability `i18n.translations`. Bind its locale resolver before migrating, so translation tables receive `locale_id` |

Versions match `composer.json`.

## Require the package

From the host application:

```bash
composer require "ugarit-artifacts/geography:^2.00.00"
```

In this monorepo the Vue lab already path-repositories `artifacts/*` and requires `ugarit-artifacts/geography`.

The kernel discovers `Ugarit\Artifacts\Geography\Providers\GeographyServiceProvider` from `art.php` and from the Composer `extra.ugarit.providers` entry. That provider loads migrations, `routes/web.php`, and `lang/` by convention.

## Migrate

```bash
php scribe migrate
```

This creates the ten tables in [SCHEMA.md](SCHEMA.md): five entities and five translation tables.

Confirm the locale column before relying on the schema:

```sql
-- expect locale_id, not locale
```

If a translation table has a `locale` string column, the i18n resolver was not bound when the migration ran.

## Routes

```bash
php scribe route:list --path=geography
```

Routes sit under `/panel/artifact/geography` and use the `web` and `auth` middleware.

## Tests

From the host application, when a Geography testsuite is configured:

```bash
php scribe test --compact --testsuite=Geography
```
