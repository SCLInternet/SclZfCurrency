<?php

return [
    'scl_currency' => [
        'currency_factory'       => 'scl_currency.currency_factory.default',
        'money_factory'          => 'scl_currency.money_factory.default',
        'taxed_price_factory'    => 'scl_currency.taxed_price_factory.default',

        'html_money_formatter'   => 'scl_currency.html_money_formatter.default',
        'string_money_formatter' => 'scl_currency.string_money_formatter.default',

        'default_currency'       => 'GBP',

        'config_path'            => __DIR__ . '/../../'
    ],
];
