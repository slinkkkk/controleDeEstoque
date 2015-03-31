<?php
/**
 * Created by PhpStorm.
 * User: mauriciofalbo
 * Date: 12/02/2015
 * Time: 15:36
 */
class EquipamentosModel extends Model{

    public function __construct()
    {
        parent::__construct("equipamentos","main");

    }

    public function listaEquipamento($where = null, $qtd = NULL , $offset = null, $order = "id_equipamentos ASC"){
        return $this->read( $where , $qtd, $offset, $order  );
    }

    public function cadastrarEquipamento( Array $dados ){
       return $this->insert($dados);
    }

    public function alterarEquipamento( Array $dados , $where){
        return $this->update($dados , $where);
    }

    public function deleteEquipamento( $where )
    {
        return $this->delete($where);
    }
}