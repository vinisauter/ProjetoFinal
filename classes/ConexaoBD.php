<?php

class ConexaoBD {

    protected $host;
    protected $user;
    protected $password;
    protected $banco;
    protected $conection;
    protected $query;
    protected $error;

    function __construct() {
        $this->host = "localhost";
        $this->user = "root";
        $this->password = "";
        $this->banco = "projetowebfinal";
        if (($this->conection = mysql_connect($this->host, $this->user, $this->password)) !== false)
            return true;
        else {
            $this->error = mysql_error();
            return false;
        }
    }

    public function __set($var, $val) {
        $this->$var = $val;
    }

    public function __get($var) {
        return $this->$var;
    }

    /**
     * Retorna o Id da conecção com o banco
     *
     * @return id
     */
    public function getConection() {
        return $this->conection;
    }

    /**
     * Retorna o nome do banco
     *
     * @return $bank
     */
    public function getBanco() {
        return $this->banco;
    }

    /**
     * Executa a ação descrita no parametro $query
     *
     * @param string $query
     */
    public function execute($query) {
        if ((mysql_select_db($this->getBanco())) === false) {
            $this->error = mysql_error();
            return false;
        }
        if (($this->query = mysql_query($query)) !== false)
            return $this->query;
        else {
            $this->error = mysql_error();
            return false;
        }
    }

    /**
     * Retorna um array com o resultado da ultima consulta no banco
     *
     * @return array
     */
    public function getArray() {
        return mysql_fetch_array($this->getQuery());
    }

    /**
     * Retorna o numero de linhas da ultima consulta realizada no banco
     *
     * @return int
     */
    public function numberOfLines() {
        return mysql_num_rows($this->getQuery());
    }

    /**
     * Retorna o id de conecção com o banco da ultima ação realizada no mesmo
     *
     * @return id
     */
    public function getQuery() {
        return $this->query;
    }

    function gerarQueryBanco($TABLE, $PARAM = '*', $WHERE = '', $ORDERBY = '', $GROUPBY = '') {
        $WHERE = ($WHERE != '') ? 'WHERE ' . $WHERE : '';
        $ORDERBY = ($ORDERBY != '') ? 'ORDER BY ' . $ORDERBY : '';
        $GROUPBY = ($GROUPBY != '') ? 'GROUP BY ' . $GROUPBY : '';
        $this->query = "SELECT {$PARAM} FROM {$TABLE} {$WHERE} {$GROUPBY} {$ORDERBY}";
        return $this->execute($this->query);
    }

    /**
     * Retorna o id do ultimo elemento inserido
     *
     * @return int
     */
    public function lastInsert() {
        return mysql_insert_id($this->getConection());
    }

    public function fetchObject() {
        return mysql_fetch_object($this->query);
    }

    public function starTransaction() {
        $this->execute("START TRANSACTION");
        return $this->execute("BEGIN");
    }

    function commit() {
        return $this->execute("COMMIT");
    }

    function rollback() {
        return $this->execute("ROLLBACK");
    }

    function getError() {
        return $this->error;
    }

}

//------------------------------------------------------------------------------

class UsuarioBD extends ConexaoBD {

    public $user_id;
    public $user_nome;
    public $user_nick;
    public $user_email;
    public $user_senha;
    public $user_sexo;
    public $user_datanasc;
    protected $xmlRetorno;
    protected $xml;
    // singleton instance 
    private static $instance;

//    // getInstance method 
//    public static function getInstance() {
//
//        if (!self::$instance) {
//            self::$instance = new self();
//        }
//
//        return self::$instance;
//    }

    public function insereUsuarioP($user_nome, $user_nick, $user_email, $user_senha, $user_sexo) {
        
        $this->query = "INSERT INTO `usuarios`(`user_nome`, `user_nick`, `user_email`, `user_senha`, `user_sexo`) VALUES 
            ('{$user_nome}','{$user_nick}','{$user_email}','{$user_senha}','{$user_sexo}')";
        $this->query = "INSERT INTO usuarios( user_nome, user_nick, user_email, user_senha, user_sexo) VALUES
                            ('{$user_nome}','{$user_nick}','{$user_email}','{$user_senha}','{$user_sexo}')";
        return $this->execute($this->query);
    }

    public function insereUsuario() {
        $this->query = "INSERT INTO usuarios(user_nome, user_nick, user_email, user_senha, user_sexo) VALUES
               ('{$this->user_nome}','{$this->user_nick}','{$this->user_email}','{$this->user_senha}','{$this->user_sexo}')";
        return $this->execute($this->query);
    }

    public function existeParametroEmBD($PARAM, $VALUE) {
        $this->query = "SELECT  `" . $PARAM . "`  FROM usuarios WHERE  `" . $PARAM . "` =  '" . $VALUE . "' LIMIT 0 , 1";
        $this->execute($this->query);
        return $this->fetchObject();
    }

    function getUsuarioBanco($PARAM = '*', $WHERE = '', $ORDERBY = '', $GROUPBY = '', $LIMIT = '50') {
        $WHERE = ($WHERE != '') ? 'WHERE ' . $WHERE : '';
        $ORDERBY = ($ORDERBY != '') ? 'ORDER BY ' . $ORDERBY : '';
        $GROUPBY = ($GROUPBY != '') ? 'GROUP BY ' . $GROUPBY : '';
        $this->query = "SELECT {$PARAM} FROM usuarios {$WHERE} {$GROUPBY} {$ORDERBY} LIMIT 0 ,{$LIMIT}";
        $this->execute($this->query);
        return $this->geraXmlRetorno();
    }

    private function geraXmlRetorno() {errado
        $xmlOb = '<UsuarioBD>';
        while ($r = $this->fetchObject()) {
            $xmlOb .= '<usuarios>';
            $xmlOb .= '<user_id>'.$r->user_id.'</user_id>';
            $xmlOb .= '<user_nome>'.$r->user_nome.'</user_nome>';
            $xmlOb .= '<user_nick>'.$r->user_nick.'</user_nick>';
            $xmlOb .= '<user_email>'.$r->user_email.'</user_email>';
            $xmlOb .= '<user_senha>'.$r->user_senha.'</user_senha>';
            $xmlOb .= '<user_sexo>'.$r->user_sexo.'</user_sexo>';
            $xmlOb .= '</usuarios>';
        }
        $xmlOb .= '</UsuarioBD>';
        return $xmlOb;
    }

    public function setMensagem() {
        return $this->parseXml();
    }

    private function parseXml() {
        $xmlDoc = new DOMDocument();
        $xmlDoc->loadXML($this->xml);

        $usuarios = $xmlDoc->getElementsByTagName('usuarios');

        $user_id = $xmlDoc->getElementsByTagName('user_id');
        $user_nome = $xmlDoc->getElementsByTagName('user_nome');
        $user_nick = $xmlDoc->getElementsByTagName('user_nick');
        $user_email = $xmlDoc->getElementsByTagName('user_email');
        $user_senha = $xmlDoc->getElementsByTagName('user_senha');
        $user_sexo = $xmlDoc->getElementsByTagName('user_sexo');
        $user_datanasc = $xmlDoc->getElementsByTagName('user_datanasc');


        foreach ($usuarios as $i => $m) {
            if (!$this->insereUsuarioP(
                            $user_id->item($i)->nodeValue, $user_nome->item($i)->nodeValue, $user_nick->item($i)->nodeValue, $user_email->item($i)->nodeValue, $user_senha->item($i)->nodeValue, $user_sexo->item($i)->nodeValue, $user_datanasc->item($i)->nodeValue))
                return false;
        }
        return true;
    }

}

//------------------------------------------------------------------------------

class MensagemBD extends ConexaoBD {

    public $msg_id;
    public $msg_user_id;
    public $msg_texto;

    public function insereMensagem() {
        $this->query = "INSERT INTO `mensagem`(`msg_user_id`, `msg_texto`) VALUES 
                            ('{$this->msg_user_id}','{$this->msg_texto}')";
        return $this->execute($this->query);
    }

    function getMensagemBanco($PARAM = '*', $WHERE = '', $ORDERBY = '', $GROUPBY = '') {
        $WHERE = ($WHERE != '') ? 'WHERE ' . $WHERE : '';
        $ORDERBY = ($ORDERBY != '') ? 'ORDER BY ' . $ORDERBY : '';
        $GROUPBY = ($GROUPBY != '') ? 'GROUP BY ' . $GROUPBY : '';
        $this->query = "SELECT {$PARAM} FROM mensagem {$WHERE} {$GROUPBY} {$ORDERBY}";
        return $this->execute($this->query);
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
