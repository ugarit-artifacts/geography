<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Models;

use Heritage\Database\Eloquent\Factories\HasFactory;
use Heritage\Database\Eloquent\Model;
use Heritage\Database\Eloquent\Relations\BelongsTo;
use Heritage\Database\Eloquent\Relations\HasMany;
use Heritage\Database\Eloquent\SoftDeletes;

/**
 * Eloquent model representing a Governorate entity, with translatable attributes (stored in its
 * translation table) and soft deletion.
 */
class Governorate extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass-assignable attributes.
     *
     * @var list<string>
     */
    protected $fillable = [
        'country_id',
        'slug',
        'code',
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
        'country_id' => 'integer',
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
     * The country the governorate belongs to.
     *
     * @return BelongsTo<Country, $this>
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * The cities of the governorate.
     *
     * @return HasMany<City, $this>
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
