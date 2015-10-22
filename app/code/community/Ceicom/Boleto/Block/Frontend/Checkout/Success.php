<?php

class Ceicom_Boleto_Block_Frontend_Checkout_Success extends Mage_Core_Block_Template
{
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('ceicom/boleto/checkout/boleto.phtml');
    }

}