<?php

if ($_POST) {
    $usuario = $_POST['username'];
    $senha = $_POST['password'];

    require_once './classes/ConexaoBD.php';
    $userBD = new UsuarioBD();

    //user_nome, user_nick, user_email, user_senha, user_sexo
    
    if ($userBD->existeParametroEmBD('user_nick', $usuario)) {
        $user = $userBD->getUsuarioBanco('*', "user_nick = '{$usuario}'");        
        //die($user->user_senha);
        if ($user->user_senha == $senha){
            setcookie('userBD', $userBD->geraXmlRetorno($user), time()+3600*24*1);
            die('true');
        }else
            setcookie('userBD', null);
            die('false');
    } else {
        setcookie('userBD', null);
        die('false');
    }
}
?>