<?php
/**
 * Created by PhpStorm.
 * User: jonatan
 * Date: 29/04/14
 * Time: 09:32
 */
class Ceicom_Boleto_CheckoutController extends Mage_Core_Controller_Front_Action
{
    /**
     * When a customer chooses BoletoBancario on Checkout/Payment page
     */
    public function indexAction()
    {
        $this->loadLayout();
        $block = $this->getLayout()->createBlock('boleto/frontend_checkout_success');
        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }

    public function redirectAction()
    {
        $session = Mage::getSingleton('checkout/session');

        /** set the quote as inactive after back from paypal    */
        $session->getQuote()->setIsActive(false)->save();
        mage::app()->getHelper('boleto')->getOrder()->sendNewOrderEmail();

        Mage::dispatchEvent('checkout_onepage_controller_success_action');

        $session->unsQuoteId();

        Mage::app()->getFrontController()->getResponse()
            ->setRedirect(Mage::getUrl('boleto/checkout/success'))
            ->sendResponse();
    }

    /*
    * when BoletoBancario returns
    * The order information at this point is in POST
    * variables.  However, you don't want to "process" the order until you
    * get validation from the IPN.
    */
    public function successAction()
    {
        $session = Mage::getSingleton('checkout/session');
        $session->setQuoteId($session->getPaypalStandardQuoteId(true));

        /**
         * set the quote as inactive after back from paypal
         */
        Mage::getSingleton('checkout/session')->getQuote()->setIsActive(false)->save();

        $this->_redirect('checkout/onepage/success', array('_secure'=>true));
    }
}