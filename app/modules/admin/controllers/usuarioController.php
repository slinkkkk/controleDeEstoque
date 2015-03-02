<?php
/**
 * Created by PhpStorm.
 * User: MAURÍCIO
 * Date: 12/12/2014
 * Time: 02:09
 */

Class Usuario extends Controller
{
    public function index_action()
    {
        $this->view("index");
    }

    public function menu()
    {
        $redirect = new RedirectorHelper();
        $this->_titleTabela = array("Nome","Ações");
        $this->_col = array("nome","acoes");
        $user = new UsuarioModel();

        $valoresTabela = $user->listaUsuarios();

        $cont = 0;
        foreach($valoresTabela as $row):
            foreach($this->_col as $coluna):
                if($coluna == "acoes")
                {
                    $this->_value[$cont][$coluna] = sprintf("<a href='%s'><button type='button' class='btn btn-red btn-icon btn-sm'> Remover <i class='entypo-cancel'> </button></a>",$redirect->setUrlParameters("id",$row["id"])->getLinkTabela("usuario","deletar",true));
                }
                elseif ($coluna == "nome")
                {
                    $this->_value[$cont][$coluna] =  $row[$coluna] .' '. $row["sobrenome"];
                }
                else
                {
                    $this->_value[$cont][$coluna] = $row[$coluna];
                }
            endforeach;
            $cont++;
         endforeach;

        $this->view("menu");
    }

    public function deletar()
    {
        $redirect = new RedirectorHelper();
        $user = new UsuarioModel();
        $id = $this->getParam("id");
        $user->deleteUsuarios(sprintf("id = %s",$id));
        $redirect->goToAction("menu",true);
    }

    public function cadastrar()
    {
        $redirect = new RedirectorHelper();
        $user = new UsuarioModel();

        $nome = htmlspecialchars(trim($_POST['nome']));
        $sobrenome = htmlspecialchars(trim($_POST['sobrenome']));
        $cpf = htmlspecialchars(trim($_POST['cpf']));
        $password = md5("prime123");



        if(($nome!= "" ) and ($cpf != "" ) and ($sobrenome != "" ))
        {
            $user->cadastrarUsuarios(array(
                "nome" => sprintf("'%s'",$nome),
                "sobrenome"  => sprintf("'%s'",$sobrenome),
                "cpf" => sprintf("'%s'",$cpf),
                "password"  => sprintf("'%s'",$password),
                "data_cadastro" => "now()"
            ));
        }
        $redirect->goToAction("menu",true);
    }
}