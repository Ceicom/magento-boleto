magento-boleto
==============

Módulo baseado no módulo do [magentobr](http://www.boleto.magentobr.com/)

Caso aconteça erro "Zend_Http_Client: Unable to read response or response is empty"
ou a impressão do boleto ficar em branco realizar os seguintes passos:

-----------------------------------------------------

1º - Em sua maquina virtual, edite o arquivo "hosts" (/etc/hosts)

2º - Adicione o endereço virtual da sua loja apontando para o ip localhost. 
Ex: 127.0.0.1  exemplo.local

3º - Salve o arquivo e verifique em sua loja. 

## Colaboradores

[@joridos](https://twitter.com/joridos)
