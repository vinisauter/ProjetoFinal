<?php

require_once './classes/ConexaoBD.php';
$userBD = new UsuarioBD();
//print_r($_POST);

$divRet = $userBD->getUsuarioBanco('*', "user_nick = '{$_POST['q']}'", '', '', '100');
//`user_nome`, `user_nick`, `user_email`, `user_senha`, `user_sexo`
while ($ret = $userBD->fetchObject()) {
    $divRet .= '<pre>' . $ret->user_nick . ': ' . $ret->user_nome . '</pre>';
}
$r['busca'] = $divRet;
$r['erro'] = $userBD->getError();
die(json_encode($r));
?>