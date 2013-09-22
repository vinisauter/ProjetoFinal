<?php

$valido = "false";
$mensagem = "Ocorreu um erro desconhecido.";

if (isset($_GET["txtNome"])) {
    if (strlen($_GET["txtNome"]) < 2) {
        $mensagem = "Nome do usuário invalido.";
    } else {
        $valido = "true";
        $mensagem = "";
    }
} else if (isset($_GET["txtEmail"])) {
    //user_id, user_nome, user_nick, user_email, user_senha, user_sexo, user_datanasc
    require_once './classes/ConexaoBD.php';
    $userBD = new UsuarioBD();

    if (!filter_var($_GET["txtEmail"], FILTER_VALIDATE_EMAIL)) {
        $mensagem = "Este endereço de e-mail não é válido";
    } else if ($userBD->existeParametroEmBD('user_email', $_GET["txtEmail"])) {
        $mensagem = "Este e-mail já esta cadastrado.";
    } else {
        $valido = "true";
        $mensagem = "";
    }
} else if (isset($_GET["txtUsername"])) {
    //user_id, user_nome, user_nick, user_email, user_senha, user_sexo, user_datanasc
    require_once './classes/ConexaoBD.php';
    $userBD = new UsuarioBD();

    if (strlen($_GET["txtUsername"]) < 6) {
        $mensagem = "Nome usuário deve ter pelo menos 8 caracteres.";
    } else if ($userBD->existeParametroEmBD('user_nick', $_GET["txtUsername"])) {
        $mensagem = "Este nome de usuário já existe. Por favor, escolha outro.";
    } else {
        $valido = "true";
        $mensagem = "";
    }
} else if (isset($_GET["txtSenha1"])) {
    if (strlen($_GET["txtSenha1"]) < 6) {
        $mensagem = "Senha deve ter pelo menos 6 caracteres.";
    } else {
        $valido = "true";
        $mensagem = "";
    }
}
echo "$valido||$mensagem";
?>