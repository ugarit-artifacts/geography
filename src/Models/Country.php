<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Models;

use Heritage\Database\Eloquent\Factories\HasFactory;
use Heritage\Database\Eloquent\Model;
use Heritage\Database\Eloquent\Relations\HasMany;
use Heritage\Database\Eloquent\SoftDeletes;

/**
 * Eloquent model representing a Country entity, with translatable attributes (stored in its
 * translation table) and soft deletion.
 */
class Country extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass-assignable attributes.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'native_name',
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
        'active' => 'boolean',
    ];

    /**
     * Fallback mapping for translatable fields.
     *
     * @var array<string, string>
     */
    protected array $translatableFallback = [
    ];

    /**
     * The governorates of the country.
     *
     * @return HasMany<Governorate, $this>
     */
    public function governorates(): HasMany
    {
        return $this->hasMany(Governorate::class);
    }
}
