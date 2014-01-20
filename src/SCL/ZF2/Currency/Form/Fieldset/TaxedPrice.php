<?php

namespace SCL\ZF2\Currency\Form\Fieldset;

use Zend\Form\Fieldset;

class TaxedPrice extends Fieldset
{
    const AMOUNT_LABEL = 'Amount';
    const TAX_LABEL    = 'Tax';

    public function init()
    {
        $this->add([
            'name' => 'amount',
            'type' => 'text',
            'options' => [
                'label' => self::AMOUNT_LABEL,
            ]
        ]);

        $this->add([
            'name' => 'tax',
            'type' => 'text',
            'options' => [
                'label' => self::TAX_LABEL,
            ]
        ]);
    }
}
