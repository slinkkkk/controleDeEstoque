<?php
/**
 * Created by PhpStorm.
 * User: MAURÍCIO
 * Date: 12/12/2014
 * Time: 02:09
 */

Class Lista extends Controller
{

    private $_modelCliente;
    private $_modelLista;
    private $_modelEquipamento;
    private $_modelListaEquipamentos;
    private $_modelUsuario;

    public function __construct()
    {
        $this->_modelCliente = new ClienteModel();
        $this->_modelLista = new ListaModel();
        $this->_modelEquipamento = new EquipamentosModel();
        $this->_modelListaEquipamentos = new ListaEquipamentoModel();
        $this->_modelUsuario = new UsuarioModel();
        parent::__construct();
    }

    public function index_action()
    {

        $listaView = array();
        $listaView['clientes'] = $this->_cliente->listaCliente(null,null,null,"nome ASC");
        $listaView['usuario'] = $this->_modelUsuario->listaUsuarios(null,null,null,"nome ASC");

        $this->view("index",$listaView);
    }

    public function menu()
    {
        $redirect = new RedirectorHelper();
        $this->_titleTabela = array("Responsável","Cliente","Data Criado","Ações");
        $this->_col = array("id_responsavel","id_cliente","data_criado","acoes");
        

        $pagina = ($this->getParam('pagina') != null) ? $this->getParam('pagina'): 1;
        $total = count( $this->_modelLista->listaLista() );
        $registros = 15;
        $dados['num_pg']= ceil($total/$registros);
        $inicio = ($registros*$pagina)-$registros;

        $valoresTabela = $this->_modelLista->listaLista(null,$registros,$inicio);

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
                    $urlLogo = $this->_cliente->listaCliente(sprintf("id = '%s'",$row[$coluna]));
                    $this->_value[$cont][$coluna] =  $this->imageTabela(TEMANEON."assets/".$urlLogo[0]["urlLogo"]);
                }
                elseif($coluna == "id_responsavel")
                {

                    $userResp = $this->_modelUsuario->listaUsuarios(sprintf("id = '%s'",$row[$coluna]));
                    $this->_value[$cont][$coluna] =  $userResp[0]["nome"].' '. $userResp[0]["sobrenome"];
                }
                else
                {
                    $this->_value[$cont][$coluna] = $row[$coluna];
                }
            endforeach;
            $cont++;
         endforeach;

        $this->view("menu",$dados);
    }

    public function imprimir()
    {

        $this->_titleTabela = array("Nome","Marca","Código","Observação");
        $this->_col = array("nome","marca","codigo","obs");

        $id = $this->getParam("id");

        $listaId = $this->_modelLista->listaLista(sprintf("id_lista_equipamento = %s",$id));
        $itens = $this->_modelListaEquipamentos->listaListaEquipamento(sprintf("id_lista_equipamento = %s",$listaId[0]["id_lista_equipamento"]));
        $valoresTabela = array();

        foreach($itens as $itensLista):
            $equipFull = $this->_modelEquipamento->listaEquipamento(sprintf("id_equipamentos = %s",$itensLista["id_equipamentos"]));
            array_push($valoresTabela ,$equipFull[0]);
        endforeach;

        $cont = 0;
        foreach($valoresTabela as $row):
            foreach($this->_col as $coluna):
                $this->_value[$cont][$coluna] = $row[$coluna];
            endforeach;
            $cont++;
        endforeach;

        $this->tabela(null,true);
    }

    public function visualizar()
    {
        

        $id = $this->getParam("id");
        $listaId = $this->_modelLista->listaLista(sprintf("id_lista_equipamento = %s",$id));
        if(count($listaId) > 0) {
            $this->_titleTabela = array("Nome", "Marca", "Código", "Observação");
            $this->_col = array("nome", "marca", "codigo", "obs");


            $itens = $this->_modelListaEquipamentos->listaListaEquipamento(sprintf("id_lista_equipamento = %s", $listaId[0]["id_lista_equipamento"]));
            $valoresTabela = array();

            foreach ($itens as $itensLista):
                $equipFull = $this->_modelEquipamento->listaEquipamento(sprintf("id_equipamentos = %s", $itensLista["id_equipamentos"]));
                array_push($valoresTabela, $equipFull[0]);
            endforeach;

            $cont = 0;
            foreach ($valoresTabela as $row):
                foreach ($this->_col as $coluna):
                    $this->_value[$cont][$coluna] = $row[$coluna];
                endforeach;
                $cont++;
            endforeach;

            $this->view("visualizarItens");
        }
        else
        {$this->view("erro");}
    }

    public function deletar()
    {
        $redirect = new RedirectorHelper();
        
        

        $id = $this->getParam("id");


        $this->_modelListaEquipamentos->deletarListaEquipamento(sprintf("id_lista_equipamento = %s",$id));
        $this->_modelLista->deletarLista(sprintf("id_lista_equipamento = %s",$id));

        $redirect->goToAction("menu",true);
    }

    public function cadastrar()
    {
        $redirect = new RedirectorHelper();
        


        $this->_cliente = htmlspecialchars(trim($_POST['cliente']));
        $responsavel = htmlspecialchars(trim($_POST['responsavel']));
        $itemCod = $_POST['itemCodigo'];


        if(($this->_cliente != "" ) and ($responsavel != "" ))
        {
            $this->_modelLista->cadastrarLista(array(
                "id_cliente" => sprintf("'%s'",$this->_cliente),
                "id_responsavel" => sprintf("'%s'",$responsavel),
                "data_criado" => "now()"
            ));

            $idLista = $this->_modelLista->listaLista(null,1,null,'id_lista_equipamento DESC');

            foreach($itemCod as $cod)
            {
                $codEquipamento = $this->_modelUsuario->listaEquipamento(sprintf("codigo = %s",$cod));
                $this->_modelListaEquipamentos->cadastrarListaEquipamento(array(
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
        if(trim($_POST['code']) != "" )
        {
            $codigo = $_POST['code'];
            $equipamentoUnico = $this->_modelUsuario->listaEquipamento(sprintf("codigo = %s",$codigo),1);

            if (sizeof($equipamentoUnico) > 0) {
                echo json_encode($equipamentoUnico);
            }
            else
                echo 1;
        }
        else{ echo 1; }
    }
}