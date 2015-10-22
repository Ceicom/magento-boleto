<?php
class Ceicom_Boleto_Model_Hash extends Mage_Core_Model_Abstract
{
    var $_dados;
    protected function _construct()
    {
        $this->_init('boleto/hash');
    }

    public function setDados(){

    }
}