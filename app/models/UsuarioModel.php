<?php
/**
 * Created by PhpStorm.
 * User: mauriciofalbo
 * Date: 12/02/2015
 * Time: 15:36
 */
class UsuarioModel extends Model{
    public function __construct()
    {
        parent::__construct("funcionarios","main");

    }

    public function listaUsuarios($where = null, $qtd = null , $offset = null, $order = 'id ASC' )
    {
        return $this->read( $where, $qtd, $offset, $order );
    }

    public function cadastrarUsuarios( Array $dados )
    {
        return $this->insert($dados);
    }
    public function deleteUsuarios( $where )
    {
        return $this->delete($where);
    }
}