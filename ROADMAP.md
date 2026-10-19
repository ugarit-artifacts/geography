# Roadmap: Ugarit Geography Artifact

### Phase 1: Territorial core (v2.00.00) — released

* Countries, governorates, cities, districts, and locations, each with a translation table.
* Capabilities for index, create, show, edit, save, destroy, and per-locale translation save/destroy.
* One save feature per entity: the record and its translations commit in a single transaction.
* Schema as documented in [SCHEMA.md](SCHEMA.md).

### Phase 2: Reference data (v1.01.00)

* Fixed seed records for a MENA territorial dataset. Seeders exist; `records()` is still empty.
* GeoJSON boundary polygons for governorates and districts.

### Later, only if the manifest grows into columns

`art.php` describes capitals, currencies, dialing codes, and flags. The tables do not have those columns yet. Adding them is a schema change, not a documentation change.
