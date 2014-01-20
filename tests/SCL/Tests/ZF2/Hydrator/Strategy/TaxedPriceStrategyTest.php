<?php

namespace SCLTests\ZF2\Currency\Hydrator\Strategy;

use SCL\ZF2\Currency\Hydrator\Strategy\TaxedPriceStrategy;
use SCL\Currency\Currency;
use SCL\Currency\TaxedPrice;
use SCL\Currency\Money;
use SCL\Currency\TaxedPriceFactory;

class TaxedPriceStrategyTest extends \PHPUnit_Framework_TestCase
{
    private $strategy;

    protected function setUp()
    {
        $this->strategy = new TaxedPriceStrategy(TaxedPriceFactory::createDefaultInstance());
    }

    public function test_is_a_strategy()
    {
        $this->assertInstanceOf(
            'Zend\Stdlib\Hydrator\Strategy\StrategyInterface',
            $this->strategy
        );
    }

    public function test_extract_returns_amount_value_from_taxed_price()
    {
        $this->assertEquals(
            10.99,
            $this->strategy->extract($this->createPrice(1099, 0))['amount']
        );
    }

    public function test_extract_returns_tax_value_from_taxed_price()
    {
        $this->assertEquals(
            1.99,
            $this->strategy->extract($this->createPrice(0, 199))['tax']
        );
    }

    public function test_throws_exception_if_value_is_not_TaxedPrice()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            '$value expected type SCL\Currency\TaxedPrice, got "string"'
        );

        $this->strategy->extract('error');
    }

    public function test_hydrate_returns_TaxedPrice()
    {
        $this->assertInstanceOf(
            'SCL\Currency\TaxedPrice',
            $this->strategy->hydrate([])
        );
    }

    public function test_hydrate_sets_amount_from_value_in_array()
    {
        $this->assertEquals(
            11.23,
            $this->strategy->hydrate(['amount' => 11.23])->getAmount()->getValue()
        );
    }

    public function test_hydrate_sets_tax_from_value_in_array()
    {
        $this->assertEquals(
            1.23,
            $this->strategy->hydrate(['tax' => 1.23])->getTax()->getValue()
        );
    }

    public function test_hydrate_uses_factory_to_create_price()
    {
        $factory = $this->getMockBuilder('SCL\Currency\TaxedPriceFactory')
                        ->disableOriginalConstructor()
                        ->getMock();

        $strategy = new TaxedPriceStrategy($factory);

        $factory->expects($this->once())
                ->method('createFromValues')
                ->with($this->equalTo(10), $this->equalTo(2));

        $strategy->hydrate(['amount' => 10, 'tax' => 2]);
    }

    public function test_hydrate_doesnt_cause_an_error_if_value_is_not_an_array()
    {
        $this->strategy->hydrate(0);
    }

    private function createPrice($amount, $tax)
    {
        $currency = new Currency('GBP', 2);

        return new TaxedPrice(
            new Money($amount, $currency),
            new Money($tax, $currency)
        );
    }
}
