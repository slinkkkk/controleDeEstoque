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
        $cliente = new ClienteModel();
        $func = new UsuarioModel();
        $listaView = array();
        $listaView['clientes'] = $cliente->listaCliente(null,null,null,"nome ASC");
        $listaView['usuario'] = $func->listaUsuarios(null,null,null,"nome ASC");

        $this->view("index",$listaView);
    }

    public function menu()
    {
        $redirect = new RedirectorHelper();
        $this->_titleTabela = array("Responsável","Cliente","Data Criado","Ações");
        $this->_col = array("id_responsavel","id_cliente","data_criado","acoes");
        $lista = new ListaModel();

        $valoresTabela = $lista->listaLista();

        $cont = 0;
        foreach($valoresTabela as $row):
            foreach($this->_col as $coluna):
                if($coluna == "acoes")
                {
                    $this->_value[$cont][$coluna] = sprintf("<a href='%s'><button type='button' class='btn btn-orange btn-icon btn-sm'> Visualizar <i class='entypo-search'></i></button></a>",$redirect->setUrlParameters("id",$row["id_lista_equipamento"])->getLinkTabela("lista","visualizar",true)) .'  '.
                                                    sprintf("<a href='%s' target='_blank'><button type='button' class='btn btn-info btn-icon btn-sm'> Print <i class='entypo-print'></i></button></a>",$redirect->setUrlParameters("id",$row["id_lista_equipamento"])->getLinkTabela("lista","imprimir",true)).'  '.
                                                    sprintf("<a href='%s'><button type='button' class='btn btn-red btn-icon btn-sm'> Remover <i class='entypo-cancel'></i> </button></a>",$redirect->setUrlParameters("id",$row["id_lista_equipamento"])->getLinkTabela("lista","deletar",true));
                }
                elseif ($coluna == "data_criado")
                {
                    $this->_value[$cont][$coluna] = date("d/m/Y",strtotime($row[$coluna]));
                }
                elseif($coluna == "id_cliente")
                {
                    $cliente = new ClienteModel();
                    $urlLogo = $cliente->listaCliente(sprintf("id = '%s'",$row[$coluna]));
                    $this->_value[$cont][$coluna] =  $this->imageTabela(TEMANEON."assets/".$urlLogo[0]["urlLogo"]);
                }
                elseif($coluna == "id_responsavel")
                {
                    $user = new UsuarioModel();
                    $userResp = $user->listaUsuarios(sprintf("id = '%s'",$row[$coluna]));
                    $this->_value[$cont][$coluna] =  $userResp[0]["nome"].' '. $userResp[0]["sobrenome"];
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

    public function imprimir()
    {
        $lista = new ListaModel();
        $equipamento = new EquipamentosModel();
        $listaEquipe = new ListaEquipamentoModel();
        $this->_titleTabela = array("Nome","Marca","Código","Observação");
        $this->_col = array("nome","marca","codigo","obs");

        $id = $this->getParam("id");

        $listaId = $lista->listaLista(sprintf("id_lista_equipamento = %s",$id));
        $itens = $listaEquipe->listaListaEquipamento(sprintf("id_lista_equipamento = %s",$listaId[0]["id_lista_equipamento"]));
        $valoresTabela = array();

        foreach($itens as $itensLista):
            $equipFull = $equipamento->listaEquipamento(sprintf("id_equipamentos = %s",$itensLista["id_equipamentos"]));
            array_push($valoresTabela ,$equipFull[0]);
        endforeach;

        $cont = 0;
        foreach($valoresTabela as $row):
            foreach($this->_col as $coluna):
                $this->_value[$cont][$coluna] = $row[$coluna];
            endforeach;
            $cont++;
        endforeach;

        $this->tabela(true);
    }

    public function visualizar()
    {
        $lista = new ListaModel();
        $equipamento = new EquipamentosModel();
        $listaEquipe = new ListaEquipamentoModel();
        $this->_titleTabela = array("Nome","Marca","Código","Observação");
        $this->_col = array("nome","marca","codigo","obs");

        $id = $this->getParam("id");

        $listaId = $lista->listaLista(sprintf("id_lista_equipamento = %s",$id));
        $itens = $listaEquipe->listaListaEquipamento(sprintf("id_lista_equipamento = %s",$listaId[0]["id_lista_equipamento"]));
        $valoresTabela = array();

        foreach($itens as $itensLista):
            $equipFull = $equipamento->listaEquipamento(sprintf("id_equipamentos = %s",$itensLista["id_equipamentos"]));
            array_push($valoresTabela ,$equipFull[0]);
        endforeach;

        $cont = 0;
        foreach($valoresTabela as $row):
            foreach($this->_col as $coluna):
                $this->_value[$cont][$coluna] = $row[$coluna];
            endforeach;
            $cont++;
        endforeach;

        $this->view("visualizarItens");
    }

    public function deletar()
    {
        $redirect = new RedirectorHelper();
        $lista = new ListaModel();
        $listaEquipe = new ListaEquipamentoModel();

        $id = $this->getParam("id");


        $listaEquipe->deletarListaEquipamento(sprintf("id_lista_equipamento = %s",$id));
        $lista->deletarLista(sprintf("id_lista_equipamento = %s",$id));

        $redirect->goToAction("menu",true);
    }

    public function cadastrar()
    {
        $redirect = new RedirectorHelper();
        $lista = new ListaModel();
        $listaEquipe = new ListaEquipamentoModel();
        $equip = new EquipamentosModel();

        $cliente = htmlspecialchars(trim($_POST['cliente']));
        $responsavel = htmlspecialchars(trim($_POST['responsavel']));
        $itemCod = $_POST['itemCodigo'];


        if(($cliente != "" ) and ($responsavel != "" ))
        {
            $lista->cadastrarLista(array(
                "id_cliente" => sprintf("'%s'",$cliente),
                "id_responsavel" => sprintf("'%s'",$responsavel),
                "data_criado" => "now()"
            ));

            $idLista = $lista->listaLista(null,1,null,'id_lista_equipamento DESC');

            foreach($itemCod as $cod)
            {
                $codEquipamento = $equip->listaEquipamento(sprintf("codigo = %s",$cod));
                $listaEquipe->cadastrarListaEquipamento(array(
                    "id_equipamentos" => sprintf("'%s'",$codEquipamento[0]["id_equipamentos"]),
                    "id_lista_equipamento" => sprintf("'%s'",$idLista[0]["id_lista_equipamento"]),
                    "data_retirado" => "now()"
                ));

            }
        }
        $redirect->goToAction("menu",true);
    }

    public function verificarItem()
    {
        $equip = new EquipamentosModel();
        if(trim($_POST['code']) != "" )
        {
            $codigo = $_POST['code'];
            $equipamentoUnico = $equip->listaEquipamento(sprintf("codigo = %s",$codigo),1);

            if (sizeof($equipamentoUnico) > 0) {
                echo json_encode($equipamentoUnico);
            }
            else
                echo 1;
        }
        else{ echo 1; }
    }
}