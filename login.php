<?php

if ($_POST) {
    $usuario = $_POST['username'];
    $senha = $_POST['password'];

    require_once './classes/ConexaoBD.php';
    $userBD = new UsuarioBD();

    //user_nome, user_nick, user_email, user_senha, user_sexo
    
    if ($userBD->existeParametroEmBD('user_nick', $usuario)) {
        $xmluser = $userBD->getUsuarioBanco('*', "user_nick = '{$usuario}'", '', '', '1');
        die($xmluser);
        if ($xmluser->getElementsByTagName('user_senha') == $senha)
            die('true');
        else
            die('false');
    } else {
        die('false');
    }
}
?>