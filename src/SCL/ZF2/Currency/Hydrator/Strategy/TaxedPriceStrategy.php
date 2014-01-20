<?php

namespace SCL\ZF2\Currency\Hydrator\Strategy;

use SCL\Currency\TaxedPrice;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;
use SCL\Currency\TaxedPriceFactory;

class TaxedPriceStrategy implements StrategyInterface
{
    /**
     * @var TaxedPriceFactory
     */
    private $factory;

    public function __construct(TaxedPriceFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param TaxedPrice $value
     *
     * @return float[]
     */
    public function extract($value)
    {
        if (!$value instanceof TaxedPrice) {
            throw new \InvalidArgumentException(sprintf(
                '$value expected type SCL\Currency\TaxedPrice, got "%s"',
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }

        return [
            'amount' => $value->getAmount()->getValue(),
            'tax'    => $value->getTax()->getValue(),
        ];
    }

    /**
     * @param mixed[] $value
     *
     * @return TaxedPrice
     */
    public function hydrate($value)
    {
        $amount = 0;
        $tax    = 0;

        if (is_array($value)) {
            $amount = isset($value['amount']) ? $value['amount'] : 0;
            $tax    = isset($value['tax']) ? $value['tax'] : 0;
        }

        return $this->factory->createFromValues($amount, $tax);
    }
}
