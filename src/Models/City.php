<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Models;

use Heritage\Database\Eloquent\Model;
use Ugarit\Artifacts\I18n\Traits\HasTranslatableAttributes;

class City extends Model
{
    use HasTranslatableAttributes;

    protected $table = 'geography_cities';

    protected $fillable = [
        'governorate_id',
        'name',
        'postal_code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function governorate()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id');
    }
}
