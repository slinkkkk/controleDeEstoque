<?php
/**
 * Created by PhpStorm.
 * User: MAURÍCIO
 * Date: 12/12/2014
 * Time: 02:09
 */

Class Cadastrar extends Controller
{
    public function index_action()
    {
        $this->view("index");
    }

    public function cadastro()
    {
        //$equipamento = new EquipamentoModel();

        $nome = htmlspecialchars($_POST['nome']);
        $marca = htmlspecialchars($_POST['marca']);
        $obs = htmlspecialchars($_POST['obs']);
        $codigo = htmlspecialchars($_POST['codigo']);
        $condicao = htmlspecialchars($_POST['condicao']);

        echo $nome."<br/>";
        echo $marca."<br/>";
        echo $obs."<br/>";
        echo $codigo."<br/>";
        echo $condicao."<br/>";

        /*
        if ($nome != "") {
            $this->$equipamento->cadastrarDepoimento(array(
                "nome" => sprintf("'%s'", $nome),
                "marca" => sprintf("'%s'", $marca),
                "obs" => sprintf("'%s'", $obs),
                "codigo" => sprintf("'%s'", $codigo),
                "condicao" => sprintf("'%s'", $condicao)
            ));
        }
        */

        //$this->redirect->goToAction("index");
    }
}