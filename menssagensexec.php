<?php

require_once './classes/ConexaoBD.php';
$userBD = new MensagemBD();

if (isset($_POST['tipo']) && $_POST['tipo'] == "addMSG") {
    $r['inserido'] = $userBD->insereMensagemP($_POST['msg_user_id'], $_POST['txtMsg']);
    $r['erro'] = $userBD->getError();
    die(json_encode($r));
} else {
    echo $userBD->getTodasMensagemBanco();
    die();
}
?>
