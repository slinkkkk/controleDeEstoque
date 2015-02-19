<?php
/**
 * Created by PhpStorm.
 * User: MAURÍCIO
 * Date: 12/12/2014
 * Time: 02:09
 */

Class Equipamento extends Controller
{
    public $equipamento;

    public function index_action()
    {
        $this->view("index");
    }

    public function menu()
    {
        $this->_col = array("nome","marca","condicao","codigo","obs");

        $equip = new EquipamentosModel();
        $this->_value = $equip->listaEquipamento();

        $this->view("menu");
    }

    public function cadastrar()
    {
        $redirect = new RedirectorHelper();
        $this->equipamento = new EquipamentosModel();

        $nome = htmlspecialchars($_POST['nome']);
        $marca = htmlspecialchars($_POST['marca']);
        $obs = htmlspecialchars($_POST['obs']);
        $codigo = htmlspecialchars($_POST['codigo']);
        $condicao = htmlspecialchars($_POST['condicao']);

        if(($nome != "") and ($marca != "") and ($codigo != "")) {

            $this->equipamento->cadastrarEquipamento(array(
                "data_criado" => "now()",
                "nome" => sprintf("'%s'", $nome),
                "marca" => sprintf("'%s'", $marca),
                "obs" => sprintf("'%s'", $obs),
                "codigo" => sprintf("'%s'", $codigo),
                "condicao" => sprintf("'%s'", $condicao)
            ));

        }
        $redirect->goToAction("index",true);
    }
}