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
        $xml = "<?xml version = \"1.0\"?><chat>";
        while ($r = $this->fetchObject()) {
            $xml .= "<mensagem>";
            $xml .= "<de>{$r->de}</de>";
            $xml .= "<para>{$r->para}</para>";
            $xml .= "<datahora>{$r->datahora}</datahora>";
            $xml .= "<datahoraf>{$r->datahora_f}</datahoraf>";
            $xml .= "<texto>{$r->mensagem}</texto>";
            $xml .= "</mensagem>";
        }
        $xml .= "</chat>";
        return $xml;
    }

    public function setMensagem() {
        return $this->parseXml();
    }

    private function parseXml() {
        $xmlDoc = new DOMDocument();
        $xmlDoc->loadXML($this->xml);

        $mensagem = $xmlDoc->getElementsByTagName('texto');
        $de = $xmlDoc->getElementsByTagName('de');
        $para = $xmlDoc->getElementsByTagName('para');
        foreach ($mensagem as $i => $m) {
            if (!$this->insertMsg($de->item($i)->nodeValue, $para->item($i)->nodeValue, $m->nodeValue))
                return false;
        }
        return true;
    }

}

class UsuarioBDa {

    public $user_id;
    public $user_nome;
    public $user_nick;
    public $user_email;
    public $user_senha;
    public $user_sexo;
    public $user_datanasc;
    private $con;
    // singleton instance 
    private static $instance;

    // private constructor function 
    // to prevent external instantiation 
    private function __construct($con = NULL) {
        if ($con == NULL) {
            $this->con = new Conection();
        } else {
            $this->con = $con;
        }
        return $this->con;
    }

    // getInstance method 
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function insereUsuario() {
        $sql = "INSERT INTO usuarios(user_id, user_nome, user_nick, user_email, user_senha, user_sexo, user_datanasc) VALUES
                            ('{$this->user_id}','{$this->user_nome}','{$this->user_nick}','{$this->user_email}','{$this->user_senha}','{$this->user_sexo}','{$this->user_datanasc}')";
        $this->con->execute_query($sql);
    }

}

?>
