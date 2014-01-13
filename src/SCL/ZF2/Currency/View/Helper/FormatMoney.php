<?php

namespace SCL\ZF2\Currency\View\Helper;

use SCL\Currency\Money;
use SCL\Currency\Money\Formatter;
use Zend\View\Helper\AbstractHelper;

class FormatMoney extends AbstractHelper
{
    /**
     * @var Formatter
     */
    private $formatter;

    public function __construct(Formatter $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * @return string
     */
    public function __invoke(Money $value)
    {
        return $this->formatter->format($value);
    }
}
