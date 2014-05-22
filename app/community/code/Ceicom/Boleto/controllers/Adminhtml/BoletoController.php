<?php
class Ceicom_Boleto_Adminhtml_BoletoController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $session = Mage::getSingleton('admin/session');
        print_r(Mage::getSingleton('admin/session'));
        if($session->isLoggedIn()){
            echo("lodado<br>");
        }else{
            echo("nao logado<br>");
        }
        echo 'admincontroller eheheh!';
    }

    public function viewAction()
    {
        echo 'view action!';
    }
}