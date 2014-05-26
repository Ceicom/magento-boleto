<?php
class Ceicom_Boleto_Block_Frontend_Checkout_Form extends Mage_Payment_Block_Info
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('ceicom/boleto/checkout/form.phtml');
    }

    public function getCustomText() {
        return Mage::helper('boleto')->getStandard()->getConfigData('custom_text');
    }
}