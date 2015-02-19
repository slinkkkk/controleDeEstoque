<?php
    class System{
        private $_url;
        private $_explode;
        public $_controller;
        public $_action;
        public $_params;
        public $_view;

        public function  __construct(){
            $this->setUrl();
            $this->setExplode();
            $this->setView();
            $this->setController();
            $this->setAction();
            $this->setParams();
        }

        private function setUrl(){
            if(isset($_GET['url']))
            {
                $preparar = explode('/', $_GET['url'].'/');
                if($preparar[0] == 'admin'){
                    $res = 'admin/';
                    if($preparar[1] == null)
                    {
                        $res .= 'index/index_action';
                    }
                    else if($preparar[1] != null && $preparar[2] == null)
                    {
                        $res .= $preparar[1].'/index_action';
                    }
                    else
                    {
                        $res .= $preparar[1].'/'.$preparar[2].'/';
                        unset( $preparar[0] , $preparar[1] , $preparar[2]);
                        $res .= implode("/",$preparar);
                    }
                }
                else
                {
                    $res = $_GET['url'];
                }
            }else{
                $res = 'index/index_action';
            }
            $this->_url = $res.'/';
		    //die($this->_url);
        }

        private function setExplode(){
            $this->_explode = explode( '/' , $this->_url );
        }
        
        private function setView(){
            $this->_view = $this->_explode[0];
        }

        private function setController(){
            $this->_controller = ($this->_explode[0] == 'admin' ? $this->_explode[1] : $this->_explode[0]);
        }
        
        private function setAction(){
            if ($this->_explode[0] == 'admin'){
                $ac = (!isset($this->_explode[2]) || $this->_explode[2] == null || $this->_explode[2] == 'index' ? 'index_action' : $this->_explode[2]);
            }else{
                $ac = (!isset($this->_explode[1]) || $this->_explode[1] == null || $this->_explode[1] == 'index' ? 'index_action' : $this->_explode[1]);
            }
            $this->_action = $ac;
        }

        private function setParams(){

            if ($this->_explode[0] == 'admin'){
                unset( $this->_explode[0], $this->_explode[1] ,$this->_explode[2]);
            }else{
                unset( $this->_explode[0], $this->_explode[1] );
            }

            array_pop( $this->_explode );

            if ( end( $this->_explode ) == null )
                array_pop( $this->_explode );

            //var_dump($this->_explode);
            $i = 0;
            if( !empty ($this->_explode) )
            {
                foreach ( $this->_explode as $val )
                {
                    if ( $i % 2 == 0 ){
                        $ind[] = $val;
                    }else{
                        $value[] = $val;
                    }
                    $i++;
                }
                //var_dump($value);
            }else{
                $ind = array();
                $value = array();
            }
            if( count($ind) == count($value) && !empty($ind) && !empty($value) )
                $this->_params = array_combine($ind, $value);
            else
                $this->_params = array();
        }

        public function getParam( $name = null )
        {
            if ( $name != null )
            {
                //die($this->_params);
                if ( array_key_exists($name,$this->_params))
                    {
                        return $this->_params[$name];
                    }
                else
                    {
                        return false;
                    }
            }
            else
                return $this->_params;
        }

        public function run(){
			//error_reporting ( E_ALL );
			//ini_set ( 'display_errors' ,  1 );
            $caminho = ($this->_view == 'admin' ?  sprintf("%s/controllers/",ADMIN) : sprintf("%s/controllers/",SITE) );
            
            $controller_path = $_SERVER['DOCUMENT_ROOT']. '/' . $caminho . $this->_controller . 'Controller.php';

            //die($controller_path);

            if( !file_exists( $controller_path ) ) {
                die("Houve um erro. O controller nao existe.<br /><br />".$controller_path);
            }

            require_once( $controller_path );

            $app = new $this->_controller();

            if (!method_exists($app, $this->_action))
                die("Esta action nao existe.". $this->_action);

            $action = $this->_action;
            $app->init();
            $app->$action();
        }
    }