<?php
/**
 * Created by PhpStorm.
 * User: mauriciofalbo
 * Date: 12/02/2015
 * Time: 15:36
 */
class ListaModel extends Model{
    public $_tabela = "lista_equipamento";

    public function listaLista($where = null, $qtd = null , $offset = null, $order = 'id_lista_equipamento ASC' )
    {
        return $this->read( $where, $qtd, $offset, $order );
    }

    public function cadastrarLista( Array $dados )
    {
        return $this->insert($dados);
    }

    public function deletarLista($where = null)
    {
        return $this->delete($where);
    }

}