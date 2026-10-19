<?php

declare(strict_types=1);

use Heritage\Database\Migrations\Migration;
use Heritage\Database\Schema\Blueprint;
use Heritage\Support\Facades\DB;
use Heritage\Support\Facades\Schema;

/**
 * Replaces global unique indexes with partial ones scoped to the parent, and tightens
 * country codes and coordinates. Safe to run after the original create migrations, and a
 * no-op when those migrations already created the refined schema.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->dropPlainUnique('countries', 'countries_code_unique');
        $this->dropPlainUnique('governorates', 'governorates_slug_unique');
        $this->dropPlainUnique('cities', 'cities_slug_unique');
        $this->dropPlainUnique('districts', 'districts_slug_unique');
        $this->dropPlainUnique('locations', 'locations_slug_unique');

        if (! $this->columnTypeContains('countries', 'code', '(2)')) {
            Schema::table('countries', function (Blueprint $table) {
                $table->string('code', 2)->change();
            });
        }

        if ($this->columnTypeContains('locations', 'latitude', 'float') || $this->columnTypeContains('locations', 'latitude', 'double')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->decimal('latitude', 10, 8)->nullable()->change();
                $table->decimal('longitude', 11, 8)->nullable()->change();
            });
        }

        $this->ensurePartial('countries', ['code']);
        $this->ensurePartial('governorates', ['country_id', 'slug']);
        $this->ensurePartial('cities', ['governorate_id', 'slug']);
        $this->ensurePartial('districts', ['city_id', 'slug']);
        $this->ensurePartial('locations', ['district_id', 'slug'], ['district_id' => 'not null']);
        $this->ensurePartial('locations', ['city_id', 'slug'], ['district_id' => 'null', 'city_id' => 'not null']);
        $this->ensurePartial('locations', ['slug'], ['city_id' => 'null', 'district_id' => 'null']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Duplicate slugs across parents cannot be folded back into one global unique index.
    }

    /**
     * Drop a unique index that still covers soft-deleted rows.
     */
    protected function dropPlainUnique(string $table, string $index): void
    {
        if (! Schema::hasIndex($table, $index)) {
            return;
        }

        $definition = $this->indexDefinition($index);

        if ($definition !== null && str_contains(strtolower($definition), 'where')) {
            return;
        }

        Schema::table($table, function (Blueprint $blueprint) use ($index) {
            $blueprint->dropUnique($index);
        });
    }

    /**
     * Create the partial unique index when this database does not already have it.
     *
     * @param  array<int, string>  $columns
     * @param  array<string, 'null'|'not null'>  $and
     */
    protected function ensurePartial(string $table, array $columns, array $and = []): void
    {
        $index = $table.'_'.implode('_', $columns).'_unique';
        $definition = strtolower((string) $this->indexDefinition($index));

        if ($definition !== '' && str_contains($definition, 'where') && str_contains($definition, 'deleted_at')) {
            foreach ($and as $column => $nullability) {
                if (! str_contains($definition, strtolower($column).' is '.$nullability)) {
                    Schema::table($table, function (Blueprint $blueprint) use ($index) {
                        $blueprint->dropUnique($index);
                    });
                    Schema::partialUnique($table, $columns, $and);

                    return;
                }
            }

            return;
        }

        if (Schema::hasIndex($table, $index)) {
            Schema::table($table, function (Blueprint $blueprint) use ($index) {
                $blueprint->dropUnique($index);
            });
        }

        Schema::partialUnique($table, $columns, $and);
    }

    /**
     * Whether the reported column type contains a fragment such as "float" or "(2)".
     */
    protected function columnTypeContains(string $table, string $column, string $fragment): bool
    {
        foreach (Schema::getColumns($table) as $definition) {
            if (($definition['name'] ?? null) !== $column) {
                continue;
            }

            $type = strtolower((string) ($definition['type'] ?? $definition['type_name'] ?? ''));

            return str_contains($type, strtolower($fragment));
        }

        return false;
    }

    /**
     * The SQL of an index, when the driver exposes it.
     */
    protected function indexDefinition(string $index): ?string
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            $sql = DB::scalar('select sql from sqlite_master where type = ? and name = ?', ['index', $index]);

            return $sql === null ? null : (string) $sql;
        }

        if ($driver === 'pgsql') {
            $sql = DB::scalar('select indexdef from pg_indexes where indexname = ?', [$index]);

            return $sql === null ? null : (string) $sql;
        }

        return null;
    }
};
