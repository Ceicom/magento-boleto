<?php
class Ceicom_Boleto_Block_Frontend_Print_Order extends Mage_Core_Block_Template
{
//    protected function _construct()
//    {
//        parent::_construct();
//        $this->setTemplate('ceicom/boleto/print/order.phtml');
//    }
//
    public function getCustomText() {
        return Mage::helper('boleto')->getStandard()->getConfigData('custom_text');
    }
}