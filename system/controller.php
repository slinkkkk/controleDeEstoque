<?php
class Controller extends System{

    public $title = "Studio Prime", $redirect, $_col = array() , $_value = array();


	protected function view( $nome ,$vars = null )
    {
        $login = false;

        if(($this->_view == 'admin') and ($login == true))
        {
            $authHelper = new AuthHelper();
            $authHelper->setLoginControllerAction("login","logar")
                       ->checkLogin();
        }

        if( is_array($vars) && count($vars) > 0 ){
            extract ($vars, EXTR_PREFIX_ALL, 'view');
        }

        if($this->_view == 'admin'){
            $layout = sprintf("%s/admin.phtml",LAYOUT);
            $caminhoView = sprintf("%s/views/%s/",ADMIN,$this->_controller);
        }else{
            $layout = sprintf("%s/default.phtml",LAYOUT);
            $caminhoView = sprintf("%s/views/%s/",SITE,$this->_controller);
        }

		$file = $caminhoView .$nome. '.phtml';
		if ( !file_exists($file) )
            die("Houve um erro. Layout não existe.");
		if ( !file_exists($layout) )
			die("Houve um erro. Layout não existe.");

		require_once( $layout );
	}


    public function login()
    {
        $layout = sprintf("%s/login.phtml",LAYOUT);
        require_once( $layout );
    }

    public function tabela()
    {
        $layout = sprintf("%s/tabela.phtml",LAYOUT);
        require_once( $layout );
    }






    public function stylesheet ( $caminho )
    {
        $caminhoFinal =  "<link rel='stylesheet' href='$caminho'>";
        echo $caminhoFinal;
    }

    public function jsScript ( $caminho )
    {
        $caminhoFinal = "<script src='$caminho'></script>";
        echo $caminhoFinal;
    }

    public function image ( $caminho , $width = "" , $height = "" , $alt = "" , $class = "")
    {
        $caminhoFinal = "<img src='$caminho' width='$width' height='$height' alt='$alt' class='$class' />";
        echo $caminhoFinal;
    }

    public function link ( $caminho )
    {
        $caminhoFinal = "<link rel='icon' href='$caminho' type='image/x-icon'>";
        echo $caminhoFinal;
    }

    public function init()
    {
        $this->redirect = new RedirectorHelper();
    }
}