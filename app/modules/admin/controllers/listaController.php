<?php
/**
 * Created by PhpStorm.
 * User: MAURÍCIO
 * Date: 12/12/2014
 * Time: 02:09
 */

Class Lista extends Controller
{
    public function index_action()
    {
        $this->view("index");
    }

    public function menu()
    {
        $this->view("menu");
    }

    public function cadastrar()
    {
        $redirect = new RedirectorHelper();
        $redirect->goToAction("index",true);
    }

    public function verificarItem()
    {
        $equip = new EquipamentosModel();
        if(trim($_POST['code']) != "" )
        {
            $codigo = $_POST['code'];
            $equipamentoUnico =  $equip->listaEquipamento(sprintf("codigo = %s",$codigo),1);

            if (sizeof($equipamentoUnico) > 0) {
                echo json_encode($equipamentoUnico);
            }
            else
                echo 1;

        }
        else{ echo 1; }
    }
}