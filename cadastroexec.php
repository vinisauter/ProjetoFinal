<?php
require_once './classes/ConexaoBD.php';
$userBD = new UsuarioBD();
//print_r($_POST);

$r['inserido'] = $userBD->insereUsuarioP($_POST['txtNome'], $_POST['txtUsername'], $_POST['txtEmail'], $_POST['txtSenha1'], $_POST['selSexo']);
$r['erro'] = $userBD->getError();
die(json_encode($r));
?>
