<?php
class Ceicom_Boleto_Model_Standard extends Mage_Payment_Model_Method_Abstract
{
    const PAYMENT_TYPE_AUTH = 'AUTHORIZATION';
    const PAYMENT_TYPE_SALE = 'SALE';

    protected $_code = 'ceicom_boleto';
    protected $_canUseInternal = true;
    protected $_canCapture = true;

    protected $_successBlockType = 'boleto/frontend_checkout_success';
    protected $_infoBlockType = 'boleto/frontend_checkout_info';
    protected $_formBlockType = 'boleto/frontend_checkout_form';

    /**
    * Return Order place redirect url
    *
    * @return string
    */
    public function getOrderPlaceRedirectUrl()
    {
        //when you click on place order you will be redirected on this url, if you don't want this action remove this method
        return Mage::getUrl('boleto/checkout/redirect/', array('_secure' => true));
    }
}