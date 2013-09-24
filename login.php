<?php

if ($_POST) {
    $usuario = $_POST['username'];
    $senha = $_POST['password'];

    require_once './classes/ConexaoBD.php';
    $userBD = new UsuarioBD();

    //user_nome, user_nick, user_email, user_senha, user_sexo
    
    if ($userBD->existeParametroEmBD('user_nick', $usuario)) {
        $user = $userBD->getUsuarioBanco('*', "user_nick = '{$usuario}'", '', '', '1');        
        //die($user->user_senha);
        if ($user->user_senha == $senha)
            die('true');
        else
            die('false');
    } else {
        die('false');
    }
}
?>