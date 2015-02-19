<?php
/**
 * Created by PhpStorm.
 * User: mauriciofalbo
 * Date: 12/02/2015
 * Time: 15:36
 */
class EquipamentoModel extends Model{
    public $_tabela = "";

    public function listaequipamento($where, $qtd, $offset = null )
    {
        return $this->read( $where, $qtd, $offset, 'nome ASC' );
    }

    public function cadastrarEquipamento( Array $dados )
    {
        return $this->insert($dados);
    }
}