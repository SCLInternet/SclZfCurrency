<?php

namespace SCL\ZF2\Currency\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;
use SCL\Currency\Money;
use SCL\Currency\MoneyFactory;

class MoneyStrategy implements StrategyInterface
{
    /**
     * @var MoneyFactory
     */
    private $factory;

    public function __construct(MoneyFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param Money $value
     *
     * @return float
     */
    public function extract($value)
    {
        if (!$value instanceof Money) {
            throw new \InvalidArgumentException(sprintf(
                '$value expected type SCL\Currency\Money, got "%s"',
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }

        return $value->getValue();
    }

    /**
     * @param mixed $value
     *
     * @return Money
     */
    public function hydrate($value)
    {
        return $this->factory->createFromValue($value);
    }
}
