<?php
class Ceicom_Boleto_AdminController extends Mage_Core_Controller_Front_Action
{
    public function _construct()
    {
        $helper = Mage::helper('boleto');
        if(!$helper->IsAdminUser()){
            Mage::app()->getFrontController()->getResponse()
                ->setRedirect(Mage::getBaseUrl())
                ->sendResponse();
            exit;
        }
    }

    public function viewAction()
    {
        $order_id = $this->getRequest()->getParam('order_id');

        if($order_id){
            $form = new Varien_Data_Form();
            $form->setAction(Mage::helper('boleto')->getBoletoRoute())
                ->setId('BoletoBancario_standard_view')
                ->setName('BoletoBancario_standard_view')
                ->setMethod('POST')
                ->setUseContainer(true);

            foreach (Mage::app()->getHelper('boleto')->getAllConfigData($order_id) as $field=>$value) {
                $form->addField($field, 'hidden', array('name'=>$field, 'value'=>$value));
            }
            $elements = $form->getElements();
            $numberofElemets = $elements->count();

            $client = new Varien_Http_Client($form->getData('action'));
            $client->setMethod(Varien_Http_Client::POST);

            for ($i=0; $i < $numberofElemets; $i++) {
                $client->setParameterPost($elements[$i]->getData('name'), $elements[$i]->getData('value'));
            }

            try{
                $response = $client->request();
                if ($response->isSuccessful()) {
                    // Decode any content-encoding (gzip or deflate) if needed
                    switch (strtolower($response->getHeader('content-encoding'))) {
                            case 'gzip':
                                     // Handle gzip encoding
                                    echo Zend_Http_Response::decodeGzip($response->getRawBody());
                                    break;
                            case 'deflate':
                                    // Handle deflate encoding
                                    echo Zend_Http_Response::decodeDeflate($response->getRawBody());
                                    break;
                            default:
                                    echo $response->getBody();
                                    break;
                    }
                }
            } catch (Exception $e) {
                Mage::getSingleton('core/session')->addError('Error'. $e);
            }
        } else {
            $this->_redirect('sales/order/index/');
            return false;
        }
    }

    public function generateAction()
    {
        require_once Mage::helper('boleto')->getTemplateBoletoUrl();
        exit();
    }

    public function sendmailAction()
    {
        $order_id = $this->getRequest()->getParam('order_id');
        mage::Helper('boleto')->sendNotificationEmail($order_id);
        $blocoRetorno = $this->getLayout()->createBlock('core/template')->setTemplate('ceicom/boleto/email/popup.phtml');
        $this->getResponse()->setBody($blocoRetorno->toHtml());
    }
}