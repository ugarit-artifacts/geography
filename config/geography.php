<?php

declare(strict_types=1);

return [
    'default_country' => env('UGARIT_DEFAULT_COUNTRY', 'SA'),
    'tables' => [
        'countries' => 'geography_countries',
        'governorates' => 'geography_governorates',
        'cities' => 'geography_cities',
        'locations' => 'geography_locations',
    ],
];
