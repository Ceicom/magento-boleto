<?php
class Ceicom_Boleto_Block_Frontend_Checkout_Info extends Mage_Payment_Block_Info
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('ceicom/boleto/checkout/info.phtml');
    }

    /**
     * Retrieve current order model instance
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        return Mage::registry('current_order');
    }

    public function getAdminUrl(){
        return Mage::getUrl('boleto/admin/view', array(
            'order_id' => $this->getOrder()->getId(),
            'key' => Mage::getSingleton("admin/session")->getEncryptedSessionId(),
            '_current' => true,
        ));
    }

    public function getSendMailUrl(){
        return Mage::getUrl('boleto/admin/sendmail', array(
            'order_id' => $this->getOrder()->getId(),
            'key' => Mage::getSingleton("admin/session")->getEncryptedSessionId(),
            '_current' => true,
        ));
    }
}