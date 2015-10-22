magento-boleto
==============

Módulo baseado no projeto [Boleto Bancário MagentoBR](http://www.boleto.magentobr.com/)

Caso aconteça o erro "Zend_Http_Client: Unable to read response or response is empty"
ou a janela de impressão do boleto ficar em branco, realizar os seguintes passos:

1º - Em sua máquina virtual, edite o arquivo "hosts" (/etc/hosts)
2º - Adicione o endereço virtual da sua loja apontando para o ip localhost. Ex: 127.0.0.1  exemplo.local
3º - Salve o arquivo e teste novamente