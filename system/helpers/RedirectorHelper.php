<?php
/**
 * Created by PhpStorm.
 * User: MAURÍCIO
 * Date: 11/12/2014
 * Time: 12:22
 */

    class RedirectorHelper{
        protected $parameters = array();

        protected function go ( $data )
        {
            header("Location: /".$data);
        }

        public function setUrlParameters ( $nome , $value )
        {
            $this->parameters[$nome] = $value;
            return $this;
        }

        protected function getUrlParameters()
        {
            $params = "";
            foreach ( $this->parameters as $name => $value)
                $params .= $name.'/'.$value.'/';
            return substr($params,0,-1);
        }

        public function goToController ( $controller , $admin = false )
        {
            $url = (!$admin ) ? $controller . '/index/' . $this->getUrlParameters() : 'admin/' . $controller . '/index/' . $this->getUrlParameters() ;

            $this->go( $url );
        }

        public function goToAction ( $action , $admin = false )
        {
            $url = (!$admin ) ? $this->getCurrentController().'/'. $action .'/'. $this->getUrlParameters() : 'admin/' . $this->getCurrentController().'/'. $action .'/'. $this->getUrlParameters() ;
            $this->go( $url );
        }

        public function goToControllerAction ( $controller , $action , $admin = false )
        {
            $url = (!$admin ) ? $controller .'/'. $action .'/'. $this->getUrlParameters() : 'admin/' . $controller .'/'. $action .'/'. $this->getUrlParameters() ;
            $this->go( $url );
        }

        public function goToIndex( $admin = false)
        {
            $url = (!$admin ) ? 'index/' : 'admin/index/' ;
            $this->go( $url );
        }

        public function goToUrl( $url )
        {
            header("Location: ".$url);
        }

        public function getCurrentController ()
        {
            global $start;
            return $start->_controller;
        }

        public function getCurrentAction ()
        {
            global $start;
            return $start->_action;
        }

        public function getLink( $controller , $action , $admin = false )
        {
            $link = (!$admin ) ? '/' . $controller .'/'. $action .'/'. $this->getUrlParameters() : '/admin/' . $controller .'/'. $action .'/'. $this->getUrlParameters() ;;
            echo $link;
        }

    }