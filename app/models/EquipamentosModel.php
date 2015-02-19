<?php
/**
 * Created by PhpStorm.
 * User: mauriciofalbo
 * Date: 12/02/2015
 * Time: 15:36
 */
class EquipamentosModel extends Model{
    public $_tabela = "equipamentos";

    public function listaEquipamento($where = null, $qtd = NULL ){
        return $this->read( $where , $qtd, null , "id_equipamentos ASC");
    }

    public function cadastrarEquipamento( Array $dados ){
       return $this->insert($dados);
    }
}