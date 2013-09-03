<?php

$valido = "false";
$mensagem = "Ocorreu um erro desconhecido.";

if (isset($_GET["txtUsername"])) {

    //TODO: verificar em bd
    $usernames = array();
    $usernames[] = "Thunay";
    $usernames[] = "Vinicius";
    $usernames[] = "Renan";
    $usernames[] = "Forebis";

    //check usernames
    if (in_array($_GET["txtUsername"], $usernames)) {
        $mensagem = "Este nome de usuário já existe. Por favor, escolha outro.";
    } else if (strlen($_GET["txtUsername"]) < 8) {
        $mensagem = "Nome usuário deve ter pelo menos 8 caracteres.";
    } else {
        $valido = "true";
        $mensagem = "";
    }
} else if (isset($_GET["txtNascimento"])) {

    $data = strtotime($_GET["txtBirthday"]);
    if ($data < 0) {
        $mensagem = "This is not a valid date.";
    } else {
        $valido = "true";
        $mensagem = "";
    }
} else if (isset($_GET["txtEmail"])) {

    if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_GET["txtEmail"])) {
        $mensagem = "Este endereço de e-mail não é válido";
    } else {
        //TODO: verificar em bd
        $valido = "true";
        $mensagem = "";
    }
}

echo "$valido||$mensagem";
?>