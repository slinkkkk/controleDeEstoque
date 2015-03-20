<?php
/**
 * Created by PhpStorm.
 * User: mauriciofalbo
 * Date: 12/02/2015
 * Time: 15:36
 */
class ClienteModel extends Model{
    public $_tabela = "clientes";

    public function listaCliente($where = null, $qtd = null , $offset = null, $order = 'id ASC' )
    {
        return $this->read( $where, $qtd, $offset, $order );
    }

    public function cadastrarCliente( Array $dados )
    {
        return $this->insert($dados);
    }
    public function deleteCliente( $where )
    {
        return $this->delete($where);
    }
}