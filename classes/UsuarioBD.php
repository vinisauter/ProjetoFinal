<?php

class UsuarioBD extends Conection {

    public $user_id;
    public $user_nome;
    public $user_nick;
    public $user_email;
    public $user_senha;
    public $user_sexo;
    public $user_datanasc;
    protected $xmlRetorno;
    protected $usuarioDe;
    protected $ultimaData;
    protected $usuarioPara;
    protected $xml;

    public function insereUsuario() {
        $sql = "INSERT INTO usuarios(user_id, user_nome, user_nick, user_email, user_senha, user_sexo, user_datanasc) VALUES
                            ('{$this->user_id}','{$this->user_nome}','{$this->user_nick}','{$this->user_email}','{$this->user_senha}','{$this->user_sexo}','{$this->user_datanasc}')";
        return $this->execute($sql);
    }

    function getUsuarioBanco($PARAM = '*', $WHERE = '', $ORDERBY = '', $GROUPBY = '') {
        $WHERE = ($WHERE != '') ? 'WHERE ' . $WHERE : '';
        $ORDERBY = ($ORDERBY != '') ? 'ORDER BY ' . $ORDERBY : '';
        $GROUPBY = ($GROUPBY != '') ? 'GROUP BY ' . $GROUPBY : '';
        $sql = "SELECT {$PARAM} FROM usuarios {$WHERE} {$GROUPBY} {$ORDERBY}";
        return $this->execute($sql);
    }

    public function getMensagens() {
        $this->getUsuarioBanco();
        return $this->geraXmlRetorno();
//            return $this->geraJson();
    }

    private function geraJson() {
        while ($r = $this->fetchObject()) {
            $mensagem .= $r;
        }
        return $mensagem;
    }

    private function geraXmlRetorno() {
        $xml = "<?xml version = \"1.0\"?><UsuarioBD>";
        while ($r = $this->fetchObject()) {
            $xml .= "<usuarios>";
            $xml .= "<user_id>{$r->user_id}</user_id>";
            $xml .= "<user_nome>{$r->user_nome}</user_nome>";
            $xml .= "<user_nick>{$r->user_nick}</user_nick>";
            $xml .= "<user_email>{$r->user_email}</user_email>";
            $xml .= "<user_senha>{$r->user_senha}</user_senha>";
            $xml .= "<user_sexo>{$r->user_sexo}</user_sexo>";
            $xml .= "<user_datanasc>{$r->user_datanasc}</user_datanasc>";
            $xml .= "</usuarios>";
        }
        $xml .= "</UsuarioBD>";
        return $xml;
    }

    public function setMensagem() {
        return $this->parseXml();
    }

    private function parseXml() {
        $xmlDoc = new DOMDocument();
        $xmlDoc->loadXML($this->xml);

        $usuarios = $xmlDoc->getElementsByTagName('usuarios');
        
        $user_id = $xmlDoc->getElementsByTagName('texto');
        $user_nome = $xmlDoc->getElementsByTagName('texto');
        $user_nick = $xmlDoc->getElementsByTagName('texto');
        $user_email = $xmlDoc->getElementsByTagName('texto');
        $user_senha = $xmlDoc->getElementsByTagName('texto');
        $user_sexo = $xmlDoc->getElementsByTagName('texto');
        $user_datanasc = $xmlDoc->getElementsByTagName('texto');


        foreach ($usuarios as $i => $m) {
            if (!$this->insertMsg(
                    $user_id->item($i)->nodeValue, 
                    $user_nome->item($i)->nodeValue, 
                    $user_nick->item($i)->nodeValue, 
                    $user_email->item($i)->nodeValue, 
                    $user_senha->item($i)->nodeValue, 
                    $user_sexo->item($i)->nodeValue, 
                    $user_datanasc->item($i)->nodeValue,
                    $m->nodeValue))
                return false;
        }
        return true;
    }

}

?>
