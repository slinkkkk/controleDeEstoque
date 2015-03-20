<?php

class Model
{
    protected $_db;
    public $_tabela;

    public function  __construct()
    {
        try {
            $this->_db = new PDO('mysql:host=mysql17.studioprime.com.br;dbname=studioprime14', 'studioprime14', 'prime159357', array(1002 => 'SET NAMES utf8'));
        } catch (Exception $e) {
            echo $e;
            exit;
        }
    }

    public function insert(Array $dados)
    {
        $campos = implode(", ", array_keys($dados));
        $valores = implode(", ", array_values($dados));

        $sql = " INSERT INTO `{$this->_tabela}` ({$campos}) VALUES ({$valores}) ";
        //var_dump($sql);exit;
        return $this->_db->query($sql);
    }

    public function read($where = null, $limit = null, $offset = null, $orderby = null)
    {
        $where = ($where != null ? "WHERE {$where}" : "");
        $limit = ($limit != null ? "LIMIT {$limit}" : "");
        $offset = ($offset != null ? "OFFSET {$offset}" : "");
        $orderby = ($orderby != null ? "ORDER BY {$orderby}" : "");
        $sql = " SELECT * FROM `{$this->_tabela}` {$where} {$orderby} {$limit} {$offset} ";
        //var_dump($sql);exit;

        $q = $this->_db->query($sql);
        $q->setFetchMode(PDO::FETCH_ASSOC);
        return $q->fetchAll();
    }

    public function update(Array $dados, $where)
    {
        foreach ($dados as $ind => $val) {
            $campos[] = "{$ind} = {$val}";
        }
        $campos = implode(", ", $campos);

        $sql =" UPDATE `{$this->_tabela}` SET {$campos} WHERE {$where} ";
        //var_dump($sql);exit;
        return $this->_db->query($sql);
    }

    public function delete($where)
    {
        $sql = " DELETE FROM `{$this->_tabela}` WHERE {$where} ";
        //var_dump($sql);exit;
        return $this->_db->query($sql);
    }

    /**
     * @param mixed $tabela
     */
    public function setTabela($tabela)
    {
        $this->_tabela = $tabela;
    }

}