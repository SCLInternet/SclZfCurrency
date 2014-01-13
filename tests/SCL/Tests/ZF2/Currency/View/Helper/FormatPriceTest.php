<?php

namespace SCL\Tests\ZF2\Currency\View\Helper;

use SCL\Currency\Currency;
use SCL\Currency\Money;
use SCL\Currency\Money\Formatter;
use SCL\Currency\Money\Formatter\HtmlContext;
use SCL\ZF2\Currency\View\Helper\FormatMoney;

class FormatMoneyTest extends \PHPUnit_Framework_TestCase
{
    private $helper;

    protected function setUp()
    {
        $formatter = Formatter::createDefaultInstance(new HtmlContext());

        $this->helper = new FormatMoney($formatter);
    }

    public function test_formats_money()
    {
        $money = new Money(455, new Currency('GBP', 2));

        $this->assertEquals('&pound; 4.55', $this->helper->__invoke($money));
    }
}
