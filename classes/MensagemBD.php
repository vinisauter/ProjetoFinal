<?php

class MensagemBD extends Conection {

    public $msg_id;
    public $msg_user_id;
    public $msg_texto;
    
    public function insereMensagem() {
        $sql = "INSERT INTO `mensagem`(`msg_id`, `msg_user_id`, `msg_texto`) VALUES 
                            ('{$this->msg_id}','{$this->msg_user_id}','{$this->msg_texto}')";
        return $this->execute($sql);
    }
    
    function getMensagemBanco($PARAM = '*', $WHERE = '', $ORDERBY = '', $GROUPBY = '') {
        $WHERE = ($WHERE != '') ? 'WHERE ' . $WHERE : '';
        $ORDERBY = ($ORDERBY != '') ? 'ORDER BY ' . $ORDERBY : '';
        $GROUPBY = ($GROUPBY != '') ? 'GROUP BY ' . $GROUPBY : '';
        $sql = "SELECT {$PARAM} FROM mensagem {$WHERE} {$GROUPBY} {$ORDERBY}";
        return $this->execute($sql);
    }
    
    
    private function geraXmlRetorno() {
        $xml = "<?xml version = \"1.0\"?><MensagemBD>";
        while ($r = $this->fetchObject()) {
            $xml .= "<mensagem>";
            $xml .= "<msg_id>{$r->msg_id}</msg_id>";
            $xml .= "<msg_user_id>{$r->msg_user_id}</msg_user_id>";
            $xml .= "<msg_texto>{$r->msg_texto}</msg_texto>";
            $xml .= "</mensagem>";
        }
        $xml .= "</MensagemBD>";
        return $xml;
    }
    
}

?>
