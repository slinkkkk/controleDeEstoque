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
        $equip = new EquipamentosModel();
        $dados = array();

        $id = $this->getParam("id");

        if($id) {
            $equipFull = $equip->listaEquipamento(sprintf("id_equipamentos = %s", $id));
            $dados['id'] = $id;
            $dados['nome'] = $equipFull[0]["nome"];
            $dados['marca'] = $equipFull[0]["marca"];
            $dados['codigo'] = $equipFull[0]["codigo"];
            $dados['condicao'] = $equipFull[0]["condicao"];
            $dados['obs'] = $equipFull[0]["obs"];
        }
        $this->view("index",$dados);
    }

    public function menu()
    {
        $redirect = new RedirectorHelper();

        $this->_titleTabela = array("Nome","Marca","Condção","Código","Observação","Ações");
        $this->_col = array("nome","marca","condicao","codigo","obs","ações");

        $equip = new EquipamentosModel();

        $pagina = ($this->getParam('pagina') != null) ? $this->getParam('pagina'): 1;
        $total = count( $equip->listaEquipamento() );
        $registros = 15;
        $dados['num_pg']= ceil($total/$registros);
        $inicio = ($registros*$pagina)-$registros;

        $valoresTabela = $equip->listaEquipamento(null,$registros,$inicio);

        $cont = 0;
        foreach($valoresTabela as $row):
            foreach($this->_col as $coluna):
                if($coluna == "ações") {
                    $this->_value[$cont][$coluna] = sprintf("<a href='%s'><button type='button' class='btn btn-gold btn-icon btn-sm'> Editar <i class='entypo-pencil'></i> </button></a>",$redirect->setUrlParameters("id",$row["id_equipamentos"])->getLinkTabela("equipamento","index",true)).' '.
                                                    sprintf("<a href='%s'><button type='button' class='btn btn-red btn-icon btn-sm'> Remover <i class='entypo-cancel'></i> </button></a>",$redirect->setUrlParameters("id",$row["id_equipamentos"])->getLinkTabela("equipamento","deletar",true));
                }else{
                    $this->_value[$cont][$coluna] = $row[$coluna];
                }
            endforeach;
            $cont++;
        endforeach;

        $this->view("menu",$dados);
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
        $redirect->goToAction("menu",true);
    }

    public function editar()
    {
        $redirect = new RedirectorHelper();
        $this->equipamento = new EquipamentosModel();

        $id = htmlspecialchars($_POST['id']);
        $nome = htmlspecialchars($_POST['nome']);
        $marca = htmlspecialchars($_POST['marca']);
        $obs = htmlspecialchars($_POST['obs']);
        $condicao = htmlspecialchars($_POST['condicao']);

        if(($nome != "") and ($marca != "")) {

            $this->equipamento->alterarEquipamento(array(
                "nome" => sprintf("'%s'", $nome),
                "marca" => sprintf("'%s'", $marca),
                "obs" => sprintf("'%s'", $obs),
                "condicao" => sprintf("'%s'", $condicao)
            ),sprintf("id_equipamentos = %d", $id));

        }

        $redirect->goToAction("menu",true);
    }

    public function deletar()
    {
        $redirect = new RedirectorHelper();
        $equip = new EquipamentosModel();
        $listaEquipe = new ListaEquipamentoModel();

        $id = $this->getParam("id");

        $listaEquipe->deletarListaEquipamento(sprintf("id_equipamentos = %s",$id));
        $equip->deleteEquipamento(sprintf("id_equipamentos = %s",$id));
        $redirect->goToAction("menu",true);

    }

}