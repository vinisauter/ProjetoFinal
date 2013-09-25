<?php

require_once './classes/ConexaoBD.php';
$userBD = new UsuarioBD();
//print_r($_POST);
//$divRet = $userBD->getUsuariosBanco('*', "user_nick LIKE '%{$_POST['q']}%'");
$userBD->getUsuariosBanco();
while ($ret = $userBD->getArray()) {
    $divRet[] = $ret;
}
$r['busca'] = $divRet;
$r['erro'] = $userBD->getError();
die(json_encode($r));
?>
