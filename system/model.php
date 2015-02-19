<?php

class Model
{
    protected $_db;
    public $_tabela;
    public $_host = "";

    public function  __construct()
    {
        try
        {
            $host = "";
            $bancoDeDados = "";
            $user = "";
            $senha = "";

            $this->_db = new PDO('mysql:host='.$host.';dbname='.$bancoDeDados, $user, $senha, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

        } catch (Exception $e) {
            echo "Problemas com o banco de dados.";
            exit;
        }
    }

    public function insert(Array $dados)
    {
        $campos = implode(", ", array_keys($dados));
        $valores = implode(", ", array_values($dados));

        $sql = " INSERT INTO `{$this->_tabela}` ({$campos}) VALUES ({$valores}) ";
        return $this->_db->query($sql);
    }

    public function read($where = null, $limit = null, $offset = null, $orderby = null)
    {
        $where = ($where != null ? "WHERE {$where}" : "");
        $limit = ($limit != null ? "LIMIT {$limit}" : "");
        $offset = ($offset != null ? "OFFSET {$offset}" : "");
        $orderby = ($orderby != null ? "ORDER BY {$orderby}" : "");
        $sql = " SELECT * FROM `{$this->_tabela}` {$where} {$orderby} {$limit} {$offset} ";
        $q = $this->_db->query($sql);
        $q->setFetchMode(PDO::FETCH_ASSOC);
        return $q->fetchAll();
    }

    public function update(Array $dados, $where)
    {
        foreach ($dados as $ind => $val) {
            $campos[] = "{$ind} = '{$val}'";
        }
        $campos = implode(", ", $campos);
        return $this->_db->query(" UPDATE `{$this->_tabela}` SET {$campos} WHERE {$where} ");
    }

    public function delete($where)
    {
        return $this->_db->query(" DELETE FROM `{$this->_tabela}` WHERE {$where} ");
    }

    /**
     * @param mixed $tabela
     */
    public function setTabela($tabela)
    {
        $this->_tabela = $tabela;
    }

}