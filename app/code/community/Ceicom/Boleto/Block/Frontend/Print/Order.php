<?php
class Ceicom_Boleto_Block_Frontend_Print_Order extends Mage_Core_Block_Template
{
    public function getCustomText() {
        return Mage::helper('boleto')->getStandard()->getConfigData('custom_text');
    }
}