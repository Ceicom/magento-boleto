<?php
/**
 * Created by PhpStorm.
 * User: jonatan
 * Date: 28/04/14
 * Time: 17:19
 */
class Ceicom_Boleto_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_BOLETO_ACTIVE                        = 'payment/ceicom_boleto/active';
    const XML_PATH_BOLETO_TITLE                         = 'payment/ceicom_boleto/title';
    const XML_PATH_BOLETO_TEMPLATE_EMAIL_SEGUNDA_VIA    = 'payment/ceicom_boleto/boleto_bancario_email_segunda_via';
    const XML_PATH_BOLETO_ORDER_STATUS                  = 'payment/ceicom_boleto/order_status';
    const XML_PATH_BOLETO_CUSTOM_TEXT                   = 'payment/ceicom_boleto/custom_text';
    const XML_PATH_BOLETO_BANCO                         = 'payment/ceicom_boleto/banco';
    const XML_PATH_BOLETO_PRAZO_PAGAMENTO               = 'payment/ceicom_boleto/prazo_pagamento';
    const XML_PATH_BOLETO_TAXA_BOLETO                   = 'payment/ceicom_boleto/taxa_boleto';
    const XML_PATH_BOLETO_DEMONSTRATIVO1                = 'payment/ceicom_boleto/demonstrativo1';
    const XML_PATH_BOLETO_DEMONSTRATIVO2                = 'payment/ceicom_boleto/demonstrativo2';
    const XML_PATH_BOLETO_DEMONSTRATIVO3                = 'payment/ceicom_boleto/demonstrativo3';
    const XML_PATH_BOLETO_INSTRUCOES1                   = 'payment/ceicom_boleto/instrucoes1';
    const XML_PATH_BOLETO_INSTRUCOES2                   = 'payment/ceicom_boleto/instrucoes2';
    const XML_PATH_BOLETO_INSTRUCOES3                   = 'payment/ceicom_boleto/instrucoes3';
    const XML_PATH_BOLETO_INSTRUCOES4                   = 'payment/ceicom_boleto/instrucoes4';
    const XML_PATH_BOLETO_SECANCELADO                   = 'payment/ceicom_boleto/secancelado';
    const XML_PATH_BOLETO_INICIO_NOSSO_NUMERO           = 'payment/ceicom_boleto/inicio_nosso_numero';
    const XML_PATH_BOLETO_DIGITOS_NOSSO_NUMERO          = 'payment/ceicom_boleto/digitos_nosso_numero';
    const XML_PATH_BOLETO_AGENCIA                       = 'payment/ceicom_boleto/agencia';
    const XML_PATH_BOLETO_AGENCIA_DV                    = 'payment/ceicom_boleto/agencia_dv';
    const XML_PATH_BOLETO_CONTA                         = 'payment/ceicom_boleto/conta';
    const XML_PATH_BOLETO_CONTA_DV                      = 'payment/ceicom_boleto/conta_dv';
    const XML_PATH_BOLETO_CONTA_CEDENTE                 = 'payment/ceicom_boleto/conta_cedente';
    const XML_PATH_BOLETO_CONTA_CEDENTE_DV              = 'payment/ceicom_boleto/conta_cedente_dv';
    const XML_PATH_BOLETO_CEDENTE                       = 'payment/ceicom_boleto/cedente';
    const XML_PATH_BOLETO_CARTEIRA                      = 'payment/ceicom_boleto/carteira';
    const XML_PATH_BOLETO_VARIACAO_CARTEIRA             = 'payment/ceicom_boleto/variacao_carteira';
    const XML_PATH_BOLETO_ESPECIE                       = 'payment/ceicom_boleto/especie';
    const XML_PATH_BOLETO_CONTRATO                      = 'payment/ceicom_boleto/contrato';
    const XML_PATH_BOLETO_CONVENIO                      = 'payment/ceicom_boleto/convenio';
    const XML_PATH_BOLETO_IDENTIFICACAO                 = 'payment/ceicom_boleto/identificacao';
    const XML_PATH_BOLETO_CPF_CNPJ                      = 'payment/ceicom_boleto/cpf_cnpj';
    const XML_PATH_BOLETO_ENDERECO                      = 'payment/ceicom_boleto/endereco';
    const XML_PATH_BOLETO_CIDADE_UF                     = 'payment/ceicom_boleto/cidade_uf';
    const XML_PATH_BOLETO_PATH_LOGO                     = 'payment/ceicom_boleto/path_logo';
    const XML_PATH_BOLETO_ALLOWSPECIFIC                 = 'payment/ceicom_boleto/allowspecific';
    const XML_PATH_BOLETO_SPECIFICCOUNTRY               = 'payment/ceicom_boleto/specificcountry';

    //HASH
    const HASH_ADMIN    = 'admin';
    const HASH_CUSTOMER = 'customer';

    var $_hash;

    public function getConfig($path, $store = null)
    {
        return Mage::getStoreConfig($path, $store);
    }

    public function moduleIsActive($store = null)
    {
        return $this->getConfig(self::XML_PATH_BOLETO_ACTIVE, $store);
    }

    public function getTemplateMail($store = null)
    {
        return $this->getConfig(self::XML_PATH_BOLETO_TEMPLATE_EMAIL_SEGUNDA_VIA, $store);
    }

    /**
     * Get singleton with strandard order transaction information
     *
     * @return Ceicom_Boleto_Model_Standard
     */
    public function getStandard()
    {
        return Mage::getSingleton('boleto/standard');
    }

    public function getBoletoRoute()
    {
        $home_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB); // Somente uma Loja.
        return $home_url .'boleto/print/gerar';
    }

    /**
     * Try to load valid order by order_id and register it
     *
     * @param int $orderId
     * @return bool
     */
    public function _loadValidOrder($orderId = null)
    {
        if (null === $orderId) {
            $orderId = (int) Mage::app()->getRequest()->getParam('order_id');
        }
        if (!$orderId) {
            return false;
        }
        $order = Mage::getModel('sales/order')->load($orderId);

        if ($this->_canViewOrder($order)) {
            Mage::register('current_order', $order);
            return true;
        }

        return false;
    }

    /**
     * Check order view availability
     *
     * @param   Mage_Sales_Model_Order $order
     * @return  bool
     */
    protected function _canViewOrder($order)
    {
        $customerId = Mage::getSingleton('customer/session')->getCustomerId();
        $availableStates = Mage::getSingleton('sales/order_config')->getVisibleOnFrontStates();

        if ($order->getId() && $order->getCustomerId() && ($order->getCustomerId() == $customerId)
            && in_array($order->getState(), $availableStates, $strict = true)
        ) {
            return true;
        }
        return false;
    }

    public function getTemplateBoletoUrl() {
        die($GLOBALS['paths'][3] . "/boleto_php/boleto_" . $this->getConfig(self::XML_PATH_BOLETO_BANCO) . ".php");
        return $GLOBALS['paths'][3] . "/boleto_php/boleto_" . $this->getConfig(self::XML_PATH_BOLETO_BANCO) . ".php";
    }

    public function getOrder($order_id = null) {
        if (empty($order_id)) {
            $order = Mage::registry('current_order');
        }
        else {
            $order = Mage::getModel('sales/order')->load($order_id);
        }

        if (empty($order)) {
            $order_id = Mage::getSingleton('checkout/session')->getLastOrderId();
            $order = Mage::getModel('sales/order')->load($order_id);
        }

        return($order);
    }

    public function getAllConfigData($order_id)
    {
        $order = $this->getOrder($order_id);
        $a = $order->getBillingAddress();
        $sArr = array(
            'base_url'			=> $this->getLibBoletoUrl(),
            'logo_url'			=> $this->getLogoPrint(),
            'store_url'			=> Mage::getBaseUrl(),
            'ref_transacao'     => $order->getRealOrderId(),
            'cliente_nome'      => $a->getFirstname().' '.$a->getLastname(),
            'cliente_cep'       => $a->getPostcode(),
            'cliente_end'       => $a->getStreet(1),
            'cliente_num'       => "?",
            'cliente_compl'     =>  $a->getStreet(2),
            'cliente_bairro'    => "?",
            'cliente_cidade'    => $a->getCity(),
            'cliente_uf'        => $a->getRegion(),
            'cliente_pais'      => "BRA",
            'cliente_cpf'       => "?",
            'total_pedido'      => $order->getGrandTotal(),
            'prazo_pagamento'	=> $this->getConfig(self::XML_PATH_BOLETO_PRAZO_PAGAMENTO),
            'taxa_boleto'		=> $this->getConfig(self::XML_PATH_BOLETO_TAXA_BOLETO),
            'inicio_nosso_numero'	=> $this->getConfig(self::XML_PATH_BOLETO_INICIO_NOSSO_NUMERO),
            'digitos_nosso_numero' => $this->getConfig(self::XML_PATH_BOLETO_DIGITOS_NOSSO_NUMERO),
            'demonstrativo1'	=> $this->getConfig(self::XML_PATH_BOLETO_DEMONSTRATIVO1),
            'demonstrativo2'	=> $this->getConfig(self::XML_PATH_BOLETO_DEMONSTRATIVO2),
            'demonstrativo3'	=> $this->getConfig(self::XML_PATH_BOLETO_DEMONSTRATIVO3),
            'instrucoes1'		=> $this->getConfig(self::XML_PATH_BOLETO_INSTRUCOES1),
            'instrucoes2'		=> $this->getConfig(self::XML_PATH_BOLETO_INSTRUCOES2),
            'instrucoes3'		=> $this->getConfig(self::XML_PATH_BOLETO_INSTRUCOES3),
            'instrucoes4'		=> $this->getConfig(self::XML_PATH_BOLETO_INSTRUCOES4),
            'banco'				=> $this->getConfig(self::XML_PATH_BOLETO_BANCO),
            'agencia'			=> $this->getConfig(self::XML_PATH_BOLETO_AGENCIA),
            'agencia_dv'		=> $this->getConfig(self::XML_PATH_BOLETO_AGENCIA_DV),
            'conta'				=> $this->getConfig(self::XML_PATH_BOLETO_CONTA),
            'conta_dv'			=> $this->getConfig(self::XML_PATH_BOLETO_CONTA_DV),
            'conta_cedente'		=> $this->getConfig(self::XML_PATH_BOLETO_CONTA_CEDENTE),
            'conta_cedente_dv'	=> $this->getConfig(self::XML_PATH_BOLETO_CONTA_CEDENTE_DV),
            'carteira'			=> $this->getConfig(self::XML_PATH_BOLETO_CARTEIRA),
            'especie'			=> $this->getConfig(self::XML_PATH_BOLETO_ESPECIE),
            'variacao_carteira'	=> $this->getConfig(self::XML_PATH_BOLETO_VARIACAO_CARTEIRA),
            'contrato'			=> $this->getConfig(self::XML_PATH_BOLETO_CONTRATO),
            'convenio'			=> $this->getConfig(self::XML_PATH_BOLETO_CONVENIO),
            'cedente'			=> $this->getConfig(self::XML_PATH_BOLETO_CEDENTE),
            'identificacao'		=> $this->getConfig(self::XML_PATH_BOLETO_IDENTIFICACAO),
            'cpf_cnpj'			=> $this->getConfig(self::XML_PATH_BOLETO_CPF_CNPJ),
            'endereco'			=> $this->getConfig(self::XML_PATH_BOLETO_ENDERECO),
            'cidade_uf'			=> $this->getConfig(self::XML_PATH_BOLETO_CIDADE_UF),
            'secancelado' 		=> $this->getConfig(self::XML_PATH_BOLETO_SECANCELADO),
        );

        $sReq = '';
        $rArr = array();
        /*replacing & char with and. otherwise it will break the post*/
        foreach ($sArr as $k=>$v) {
            $value =  str_replace("&","and",$v);
            $rArr[$k] =  $value;
            $sReq .= '&'.$k.'='.$value;
        }

        return $rArr;
    }

    public function getLibBoletoUrl() {
        $urlBase = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN);
        $urlBase = 'http://' . $this->getHost($urlBase);

        $ret = $urlBase . "/lib/boleto_php";

        return $ret;
    }

    private function getHost($url) {
        // get host name from URL
        preg_match('@^(?:http(s*)://)?([^/]+)@i', $url, $matches);

        return $matches[1] . $matches[2];
    }

    public function getLogoPrint()
    {
        $pathLogo = $this->getConfig(self::XML_PATH_BOLETO_PATH_LOGO);
        if ($pathLogo == '') {
            $pathLogo = 'images/logo_print.gif';
        }
        return Mage::getDesign()->getSkinUrl($pathLogo);
    }

    public function IsAdminUser()
    {
        $sesId = isset($_COOKIE['adminhtml']) ? $_COOKIE['adminhtml'] : false ;
        $session = false;
        if($sesId){
            $session = Mage::getSingleton('core/resource_session')->read($sesId);
        }
        echo('<pre>');
        print_r($session);
        die();
        $loggedIn = false;
        if($session)
        {
            if(stristr($session,'Mage_Admin_Model_User'))
            {
                $loggedIn = true;
            }
        }
        return $loggedIn;
    }

    public function IsCustomerUser()
    {
        Mage::getSingleton('core/session', array('name'=>'frontend'));
        return Mage::getSingleton('customer/session')->isLoggedIn();
    }
}