<?php
class Ceicom_Boleto_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        Mage::getSingleton('core/session', array('name' => 'adminhtml'))->start();

        $admin_logged_in = Mage::getSingleton('admin/session', array('name' => 'adminhtml'))->isLoggedIn();
        Mage::getSingleton('core/session', array('name' => $this->_sessionNamespace))->start();
        if($admin_logged_in){
            echo "Admin Logged in";
        }
        else
        {
            echo "You need to be logged in as an admin.";
        }
        echo 'Hello Index backend!';
    }

    public function viewAction()
    {
        echo 'view action!';
    }
}