<?php

namespace SCL\Tests\ZF2\Currency\Hydrator\Strategy;

use SCL\ZF2\Currency\Hydrator\Strategy\MoneyStrategy;
use SCL\Currency\Money;
use SCL\Currency\Currency;
use SCL\Currency\MoneyFactory;

class MoneyStrategyTest extends \PHPUnit_Framework_TestCase
{
    private $strategy;

    protected function setUp()
    {
        $this->strategy = new MoneyStrategy(MoneyFactory::createDefaultInstance());
    }

    public function test_is_a_strategy()
    {
        $this->assertInstanceOf(
            'Zend\Stdlib\Hydrator\Strategy\StrategyInterface',
            $this->strategy
        );
    }

    public function test_extract_returns_value_from_money()
    {
        $this->assertEquals(12.99, $this->strategy->extract($this->createMoney(1299)));
    }

    public function test_extract_throws_if_value_is_not_Money()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            '$value expected type SCL\Currency\Money, got "string"'
        );

        $this->strategy->extract('error');
    }

    public function test_hydrate_returns_Money()
    {
        $this->assertInstanceOf(
            'SCL\Currency\Money',
            $this->strategy->hydrate(0)
        );
    }

    public function test_hydrate_sets_value_of_Money()
    {
        $this->assertEquals(
            12.99,
            $this->strategy->hydrate(12.99)->getValue()
        );
    }

    public function test_hydrate_uses_factory_to_create_Money()
    {
        $factory = $this->getMockBuilder('SCL\Currency\MoneyFactory')
                        ->disableOriginalConstructor()
                        ->getMock();

        $strategy = new MoneyStrategy($factory);

        $factory->expects($this->once())
                ->method('createFromValue')
                ->with($this->equalTo(12.99));

        $strategy->hydrate(12.99);
    }

    private function createMoney($units)
    {
       return new Money($units, new Currency('GBP', 2));
    }
}
