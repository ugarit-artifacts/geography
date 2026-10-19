# Ugarit Geography Artifact (`ugarit-artifacts/geography`)

> **"Artifacts provide capabilities. Features define behavior."**

The **Geography Artifact** is the territorial registry of the Ugarit ecosystem. It stores countries, governorates, cities, districts, and locations, with translated names, and exposes them as capabilities other artifacts can require.

It runs inside a host Ugarit application. It is not a standalone framework.

## Documentation

- [Overview](OVERVIEW.md)
- [Architecture](ARCHITECTURE.md)
- [Database schema](SCHEMA.md)
- [Installation](INSTALLATION.md)
- [Roadmap](ROADMAP.md)
- [Changelog](CHANGELOG.md)
- [Contributing](CONTRIBUTING.md)
- [Security](SECURITY.md)
- [Code of Conduct](CODE_OF_CONDUCT.md)
- [Contact](CONTACT.md)
- [License](LICENSE.md)

## Role in the ecosystem

| Layer | Package | Responsibility |
| :--- | :--- | :--- |
| **Kernel** | `ugarit/framework` | Container, schema builder, capability and feature pipeline |
| **Artifact** | `ugarit-artifacts/i18n` | Locales. Translation rows store `locale_id` |
| **Artifact** | `ugarit-artifacts/geography` | Territorial hierarchy and geospatial points |

`art.php` requires the capability `i18n.translations` before this artifact boots.

## Capabilities

Declared in `art.php`:

| Slug | What the tables store today |
| :--- | :--- |
| `countries` | Unique country code, native name, translated name, active flag |
| `governorates` | First-level division of a country: slug, optional code, translated name |
| `cities` | Municipality under a governorate: slug, optional postal code, translated name |
| `districts` | Subdivision of a city: slug, optional code and postal code, translated name |
| `locations` | Point and address, optionally under a city and a district |

The structural diagram, columns, keys, and delete rules are in [SCHEMA.md](SCHEMA.md).

## Routes

Registered from `routes/web.php` under `panel/artifact/geography`, with `web` and `auth` middleware.

| Kind | Path | Purpose |
| :--- | :--- | :--- |
| **GET** | `/panel/artifact/geography` | Artifact summary |
| **RESOURCE** | `…/country`, `governorate`, `city`, `district`, `location` | Capability CRUD |
| **RESOURCE** | `…/{entity}-feature` (`store`, `update`) | Save the record and its translations in one transaction |
| **RESOURCE** | `…/{record}/{entity}-translation` (`store`, `update`, `destroy`) | One locale at a time |

## Quick start

```bash
composer require "ugarit-artifacts/geography:^2.00.00"
php scribe migrate
```

See [Installation](INSTALLATION.md).

## License

MIT. See [LICENSE.md](LICENSE.md). Maintained by **Muath R Abu Ouda**.
