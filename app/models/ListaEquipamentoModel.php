<?php
/**
 * Created by PhpStorm.
 * User: mauriciofalbo
 * Date: 12/02/2015
 * Time: 15:36
 */
class ListaEquipamentoModel extends Model{

    public function __construct()
    {
        parent::__construct("lista_equipamento_item");

    }

    public function listaListaEquipamento($where, $qtd = null , $offset = null , $order = 'id_lista_equipamento_item ASC' )
    {
        return $this->read( $where, $qtd, $offset, $order );
    }

    public function cadastrarListaEquipamento( Array $dados )
    {
        return $this->insert($dados);
    }

    public function deletarListaEquipamento($where = null)
    {
        return $this->delete($where);
    }
}