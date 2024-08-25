<?php

declare(strict_types=1);

use Illuminate\Support\Carbon;

return [
    'flexible_casting' => false,

    'superfluous_casting' => false,

    'permissive_casting' => false,

    /**
     * From the docs: Timestamp and RFC3339
     *
     * @see https://valinor.cuyz.io/latest/how-to/deal-with-dates
     */
    'supported_date_formats' => [
        // DATE_ATOM,
        // DATE_COOKIE,
    ],

    'datetime_class' => Carbon::class,
];
