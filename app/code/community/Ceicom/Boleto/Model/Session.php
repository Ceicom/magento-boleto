<?php
class Ceicom_Boleto_Model_Session extends Mage_Core_Model_Session_Abstract
{

    public function __construct() {

        $namespace = 'boleto';

        $this->init($namespace);
        Mage::dispatchEvent('ahhh_session_init', array('ahhh_session' => $this));
        session_start();
    }

}