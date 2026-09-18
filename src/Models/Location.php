<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Models;

use Heritage\Database\Eloquent\Model;
use Ugarit\Artifacts\I18n\Traits\HasTranslatableAttributes;

class Location extends Model
{
    use HasTranslatableAttributes;

    protected $table = 'geography_locations';

    protected $fillable = [
        'city_id',
        'name',
        'latitude',
        'longitude',
        'address_line',
        'postal_code',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
