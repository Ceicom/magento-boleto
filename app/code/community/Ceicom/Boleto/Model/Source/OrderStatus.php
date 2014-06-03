<?php
/**
 * Ceicom
 *
 * @category   Boleto
 * @package    Ceicom_Boleto
 * @author     Jonatan Ribeiro (@joridos)
 * @copyright  Copyright (c) 2014 Ceicom - http://www.ceicom.com.br
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Ceicom_Boleto_Model_Source_OrderStatus
 {
    public function toOptionArray()
    {
        $orderStatus = Mage::getModel('sales/order_status')->getResourceCollection()->getData();
        $returnvalue = [];
        for ($i=0; $i < count($orderStatus); $i++) {
            $returnvalue[$i]['value'] = $orderStatus[$i]['status'];
            $returnvalue[$i]['label'] = $orderStatus[$i]['label'];
        }
        return $returnvalue;
    }
 }
