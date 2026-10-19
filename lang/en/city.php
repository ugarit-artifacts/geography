<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Naming
    |--------------------------------------------------------------------------
    | How the city is referred to across the UI and the feedback messages.
    */

    'name' => 'City',
    'singular' => 'City',
    'plural' => 'Cities',
    'plural_definite' => 'The Cities',

    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    | The label and placeholder of each field in forms, tables and validation messages.
    */

    'attributes' => [
        'governorate_id' => [
            'label' => 'Governorate',
            'placeholder' => null,
        ],

        'slug' => [
            'label' => 'Slug',
            'placeholder' => null,
        ],

        'postal_code' => [
            'label' => 'Postal Code',
            'placeholder' => null,
        ],

        'active' => [
            'label' => 'Active',
            'placeholder' => null,
        ],

        'name' => [
            'label' => 'Name',
            'placeholder' => null,
        ],

        'created_at' => [
            'label' => 'Created At',
            'placeholder' => null,
        ],

        'updated_at' => [
            'label' => 'Updated At',
            'placeholder' => null,
        ],

        'force' => [
            'label' => 'Force',
            'placeholder' => null,
        ],
    ],
];
