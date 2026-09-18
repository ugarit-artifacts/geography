<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Models;

use Heritage\Database\Eloquent\Model;
use Ugarit\Artifacts\I18n\Traits\HasTranslatableAttributes;

class Country extends Model
{
    use HasTranslatableAttributes;

    protected $table = 'geography_countries';

    protected $fillable = [
        'name',
        'iso_alpha_2',
        'iso_alpha_3',
        'dial_code',
        'currency_code',
        'flag_emoji',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function governorates()
    {
        return $this->hasMany(Governorate::class, 'country_id');
    }
}
