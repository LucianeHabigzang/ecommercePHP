<?php
session_start();
// CONFIGURAÇÔES
define('FUNC', '/funcoes');
define('DS', DIRECTORY_SEPARATOR);

//*Teste
define('ROOT', __DIR__);
define('SITEBASE', 'http://'.$_SERVER['SERVER_NAME'].'/vendasOnLine');
define('TMP', 'C:/wamp/tmp/');

/*///Produção
define('ROOT', '/home/dying927/public_html');
define('SITEBASE', 'http://'.$_SERVER['SERVER_NAME']);
define('TMP', '/home/dying927/tmp/');
//*/

//INCLUSÔES DO SISTEMA
include_once ROOT.FUNC.'/carregar_funcoes.php';

// LOAD DE FUNCOES
load_funcoes(array('conexao', 'url', 'prod', 'geral', 'user', 'pedi', 'boleto_bradesco', 'mail'));

?>