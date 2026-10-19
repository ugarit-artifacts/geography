# Overview: Ugarit Geography Artifact

Geography is the shared address book of the platform: a country contains governorates, a governorate contains cities, a city contains districts, and a location hangs off a city, a district, or both.

Every place has a stable identifier (a country `code`, or a `slug` on the levels below it) and a name that lives in a translation row, one row per locale. Soft deletion keeps a place recoverable. Hard-deleting a parent is refused while children still point at it, except locations, whose city and district links are cleared when that parent disappears.

The artifact depends on i18n for the locale each translation belongs to. The `locales` table itself stays in the i18n artifact; geography only references it.
