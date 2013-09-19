<?php

class Conection {

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

?>
