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
    //TODO: verificar em bd
    $emails = array();
    $emails[] = "andre@hotmail.com";
    $emails[] = "vinicius@gmail.com";
    $emails[] = "renan@gmail.com";
    $emails[] = "forebis@gmail.com";

    if (in_array($_GET["txtEmail"], $emails)) {
        $mensagem = "Este e-mail já esta cadastrado.";
    } else if (!filter_var($_GET["txtEmail"], FILTER_VALIDATE_EMAIL)) {
        $mensagem = "Este endereço de e-mail não é válido";
    } else {
        $valido = "true";
        $mensagem = "";
    }
} else if (isset($_GET["txtUsername"])) {
    //TODO: verificar em bd
    $usernames = array();
    $usernames[] = "Andre";
    $usernames[] = "Vinicius";
    $usernames[] = "Renan";
    $usernames[] = "Forebis";

    if (in_array($_GET["txtUsername"], $usernames)) {
        $mensagem = "Este nome de usuário já existe. Por favor, escolha outro.";
    } else if (strlen($_GET["txtUsername"]) < 8) {
        $mensagem = "Nome usuário deve ter pelo menos 8 caracteres.";
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