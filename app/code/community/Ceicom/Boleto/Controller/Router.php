<?php
/**
 * Created by PhpStorm.
 * User: Ceicom Tecnologia
 * Date: 20/02/14
 * Time: 17:25
 */
class Ceicom_Boleto_Controller_Router extends Mage_Core_Controller_Varien_Router_Abstract
{
    public function initControllerRouters($observer)
    {
        //$front = $observer->getEvent()->getFront();
        //$boleto = new Ceicom_Boleto_Controller_Router();
        //$front->addRouter('boleto',$boleto);
//        echo("<pre>");
//        die(print_r(Mage::app()->getFrontController()));
    }

    /**
     * @param Zend_Controller_Request_Http $request
     * @internal param \Ceicom_Boleto_Helper_Data $helper
     * @return bool
     */
    public function match(Zend_Controller_Request_Http $request)
    {
        $identifier = explode('/',$request->getPathInfo());
        $route['main'] = ($identifier[1] != '') ? $identifier[1] : '';
        $route['controller'] = ($identifier[2] != '') ? $identifier[2] : '';
        $route['action'] = ($identifier[3] != '') ? $identifier[3] : '';

        if((isset($route['main']))&&($route['main'] != '')&&($route['main'] == 'boleto')){

            $helper = Mage::helper('boleto');
            $controller = '';
            $action = '';
            if($helper->IsAdmin()){
                $controller = 'admin';
            }else if($helper->IsUser()){
                $controller = 'customer';
            }else{
                Mage::app()->getFrontController()->getResponse()
                    ->setRedirect(Mage::getBaseUrl())
                    ->sendResponse();
                exit;
            }

            if((isset($route['action']))&&($route['action'] == 'generate')){
                $action = 'generate';
            }else if((isset($route['action']))&&($route['action'] == 'view')){
                $action = 'view';
            }
            $request->setModuleName('boleto')
                ->setControllerName($controller)
                ->setActionName($action);
            return true;
        }
        return false;
    }
}