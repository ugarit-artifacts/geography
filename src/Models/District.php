<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Models;

use Heritage\Database\Eloquent\Factories\HasFactory;
use Heritage\Database\Eloquent\Model;
use Heritage\Database\Eloquent\Relations\BelongsTo;
use Heritage\Database\Eloquent\Relations\HasMany;
use Heritage\Database\Eloquent\SoftDeletes;

/**
 * Eloquent model representing a District entity, with translatable attributes (stored in its
 * translation table) and soft deletion.
 */
class District extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass-assignable attributes.
     *
     * @var list<string>
     */
    protected $fillable = [
        'city_id',
        'slug',
        'code',
        'postal_code',
        'active',
    ];

    /**
     * Translatable attribute keys handled by the translation layer.
     *
     * @var list<string>
     */
    protected array $translatable = [
        'name',
    ];

    /**
     * Attribute casting definitions.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'city_id' => 'integer',
        'active' => 'boolean',
    ];

    /**
     * Fallback mapping for translatable fields.
     *
     * @var array<string, string>
     */
    protected array $translatableFallback = [
        'name' => 'slug',
    ];

    /**
     * The city the district belongs to.
     *
     * @return BelongsTo<City, $this>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * The locations of the district.
     *
     * @return HasMany<Location, $this>
     */
    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }
}
