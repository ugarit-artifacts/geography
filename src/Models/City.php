<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Models;

use Heritage\Database\Eloquent\Factories\HasFactory;
use Heritage\Database\Eloquent\Model;
use Heritage\Database\Eloquent\Relations\BelongsTo;
use Heritage\Database\Eloquent\Relations\HasMany;
use Heritage\Database\Eloquent\SoftDeletes;

/**
 * Eloquent model representing a City entity, with translatable attributes (stored in its
 * translation table) and soft deletion.
 */
class City extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass-assignable attributes.
     *
     * @var list<string>
     */
    protected $fillable = [
        'governorate_id',
        'slug',
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
        'governorate_id' => 'integer',
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
     * The governorate the city belongs to.
     *
     * @return BelongsTo<Governorate, $this>
     */
    public function governorate(): BelongsTo
    {
        return $this->belongsTo(Governorate::class);
    }

    /**
     * The districts of the city.
     *
     * @return HasMany<District, $this>
     */
    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }

    /**
     * The locations of the city.
     *
     * @return HasMany<Location, $this>
     */
    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }
}
