<?php

return [
    'scl_currency' => [
        'currency_factory'    => 'scl_currency.currency_factory.default',
        'money_factory'       => 'scl_currency.money_factory.default',
        'taxed_price_factory' => 'scl_currency.taxed_price_factory.default',

        'default_currency'    => 'GBP',

        'config_path'         => __DIR__ . '/../../'
    ],
];
