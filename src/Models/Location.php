<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Models;

use Heritage\Database\Eloquent\Factories\HasFactory;
use Heritage\Database\Eloquent\Model;
use Heritage\Database\Eloquent\Relations\BelongsTo;
use Heritage\Database\Eloquent\SoftDeletes;

/**
 * Eloquent model representing a Location entity, with translatable attributes (stored in its
 * translation table) and soft deletion.
 */
class Location extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass-assignable attributes.
     *
     * @var list<string>
     */
    protected $fillable = [
        'city_id',
        'district_id',
        'slug',
        'latitude',
        'longitude',
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
        'address_line',
    ];

    /**
     * Attribute casting definitions.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'city_id' => 'integer',
        'district_id' => 'integer',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'active' => 'boolean',
    ];

    /**
     * Fallback mapping for translatable fields.
     *
     * @var array<string, string>
     */
    protected array $translatableFallback = [
        'name' => 'slug',
        'address_line' => 'slug',
    ];

    /**
     * The city the location belongs to.
     *
     * @return BelongsTo<City, $this>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * The district the location belongs to.
     *
     * @return BelongsTo<District, $this>
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
}
