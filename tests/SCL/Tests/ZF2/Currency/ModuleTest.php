<?php

namespace SCL\Tests\ZF2\Currency;

use SclTest\Zf2\AbstractTestCase;

class ModuleTest extends AbstractTestCase
{
    /*
     * Default services
     */

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

    public function test_service_manager_creates_default_html_formatter()
    {
        $this->assertServiceIsInstanceOf(
            'SCL\Currency\Money\Formatter',
            'scl_currency.html_money_formatter.default'
        );
    }

    public function test_service_manager_creates_default_string_formatter()
    {
        $this->assertServiceIsInstanceOf(
            'SCL\Currency\Money\Formatter',
            'scl_currency.string_money_formatter.default'
        );
    }

    /*
     * Config services.
     */

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

    public function test_service_manager_creates_html_formatter()
    {
        $this->assertServiceIsInstanceOf(
            'SCL\Currency\Money\Formatter',
            'scl_currency.html_money_formatter'
        );
    }

    public function test_service_manager_creates_string_formatter()
    {
        $this->assertServiceIsInstanceOf(
            'SCL\Currency\Money\Formatter',
            'scl_currency.string_money_formatter'
        );
    }

    public function test_service_manager_creates_money_strategy()
    {
        $this->assertServiceIsInstanceOf(
            'SCL\ZF2\Currency\Hydrator\Strategy\MoneyStrategy',
            'SCL\ZF2\Currency\Hydrator\Strategy\MoneyStrategy'
        );
    }

    /*
     * View helper config
     */

    public function test_formatMoney_view_helper_is_created()
    {
        $vhm = $this->getServiceManager()->get('ViewHelperManager');

        $this->assertInstanceOf(
            'SCL\ZF2\Currency\View\Helper\FormatMoney',
            $vhm->get('formatMoney')
        );
    }

    /*
     * Hydrator config
     */

    public function test_taxed_price_hydrator()
    {
        $hm = $this->getServiceManager()->get('HydratorManager');

        $this->assertInstanceOf(
            'Zend\Stdlib\Hydrator\HydratorInterface',
            $hm->get('scl_currency.taxed_price_hydrator')
        );
    }

    /*
     * Form element config
     */

    public function test_taxed_price_element()
    {
        $fem = $this->getServiceManager()->get('FormElementManager');

        $this->assertInstanceOf(
            'SCL\ZF2\Currency\Form\Fieldset\TaxedPrice',
            $fem->get('SCL\ZF2\Currency\Form\Fieldset\TaxedPrice')
        );
    }
}
