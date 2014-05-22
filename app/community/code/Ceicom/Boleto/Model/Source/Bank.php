<?php
/**
 * Ceicom
 *
 * @category   Boleto
 * @package    Ceicom_Boleto
 * @author     Jonatan Ribeiro (@CBJonatanSantos)
 * @copyright  Copyright (c) 2014 Ceicom - http://www.ceicom.com.br
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Ceicom_Boleto_Model_Source_Bank
 {
    public function toOptionArray()
    {
        return array(
            array('value' => 'hsbc', 'label' => 'HSBC'),
            array('value' => 'cef', 'label' => 'Caixa Econômica Federal'),
            array('value' => 'cef_sigcb', 'label' => 'Caixa Econômica Federal - SIGCB'),
            array('value' => 'caixa', 'label' => 'Caixa Econômica Federal - Alternativo'),
            array('value' => 'cef_sinco', 'label' => 'Caixa Econômica Federal - SINCO'),
            array('value' => 'bb', 'label' => 'Banco do Brasil'),
            array('value' => 'bradesco', 'label' => 'Bradesco'),
            array('value' => 'itau', 'label' => 'Itaú'),
            array('value' => 'santander_banespa', 'label' => 'Santander'),
        );
    }
 }
