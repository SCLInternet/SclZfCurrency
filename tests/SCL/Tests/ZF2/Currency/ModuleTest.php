<?php

namespace SCL\Tests\ZF2\Currency;

use SclTest\Zf2\AbstractTestCase;

class ModuleTest extends AbstractTestCase
{
    public function test_service_manager_creates_default_currency_factory()
    {
        $this->assertServiceIsInstanceOf(
            'SCL\Currency\CurrencyFactory',
            'scl_currency.currency_factory.default'
        );
    }

    public function test_service_manager_creates_default_money_factory()
    {
        $this->assertServiceIsInstanceOf(
            'SCL\Currency\MoneyFactory',
            'scl_currency.money_factory.default'
        );
    }

    public function test_service_manager_creates_default_taxed_price_factory()
    {
        $this->assertServiceIsInstanceOf(
            'SCL\Currency\TaxedPriceFactory',
            'scl_currency.taxed_price_factory.default'
        );
    }

    public function test_service_manager_creates_currency_factory()
    {
        $this->assertServiceIsInstanceOf(
            'SCL\Currency\CurrencyFactory',
            'scl_currency.currency_factory'
        );
    }

    public function test_service_manager_creates_money_factory()
    {
        $this->assertServiceIsInstanceOf(
            'SCL\Currency\MoneyFactory',
            'scl_currency.money_factory'
        );
    }

    public function test_service_manager_creates_taxed_price_factory()
    {
        $this->assertServiceIsInstanceOf(
            'SCL\Currency\TaxedPriceFactory',
            'scl_currency.taxed_price_factory'
        );
    }
}
