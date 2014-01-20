<?php

namespace SCL\Tests\ZF2\Currency\Form\Fieldset;

use SCL\ZF2\Currency\Form\Fieldset\TaxedPrice;

class TaxedPriceTest extends \PHPUnit_Framework_TestCase
{
    private $form;

    protected function setUp()
    {
        $this->form = new TaxedPrice();

        $this->form->init();
    }

    public function test_is_a_fieldset()
    {
        $this->assertInstanceOf(
            'Zend\Form\Fieldset',
            $this->form
        );
    }

    public function test_it_has_an_amount_element()
    {
        $this->assertInstanceOf(
            'Zend\Form\Element\Text',
            $this->form->get('amount')
        );
    }

    public function test_amount_element_label()
    {
        $this->assertEquals('Amount', $this->form->get('amount')->getLabel());
    }

    public function test_it_has_a_tax_element()
    {
        $this->assertInstanceOf(
            'Zend\Form\Element\Text',
            $this->form->get('tax')
        );
    }

    public function test_tax_element_label()
    {
        $this->assertEquals('Tax', $this->form->get('tax')->getLabel());
    }
}
