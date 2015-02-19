<?php
/**
 * Created by PhpStorm.
 * User: MAURÍCIO
 * Date: 11/12/2014
 * Time: 16:21
 */

    class AuthHelper
    {
        protected $sessionHelper , $redirectorHelper, $tableName , $userColumn, $passColumn ,
                  $user , $pass, $loginController = 'index' ,$loginAction = 'index',
                  $logoutController = 'index' , $logoutAction = 'index';



        public function __construct()
        {
            $this->sessionHelper = new SessionHelper();
            $this->redirectorHelper = new RedirectorHelper();
            return $this;
        }

        public function setTableName ( $val )
        {
            $this->tableName = $val;
            return $this;
        }

        public function setUserColumn ( $val )
        {
            $this->userColumn = $val;
            return $this;
        }

        public function setPassColumn ( $val )
        {
            $this->passColumn = $val;
            return $this;
        }

        public function setUser ( $val )
        {
            $this->user = $val;
            return $this;
        }

        public function setPass ( $val )
        {
            $this->pass = $val;
            return $this;
        }

        public function setLoginControllerAction ( $controller , $action )
        {
            $this->loginController = $controller;
            $this->loginAction = $action;
            return  $this;
        }

        public function setLogoutControllerAction ( $controller , $action )
        {
            $this->logoutController = $controller;
            $this->logoutAction = $action;
            return  $this;
        }

        public function login()
        {
            $resp = array();

            //This array of data is returned for demo purpose, see assets/js/neon-forgotpassword.js
            $resp['submitted_data'] = $_POST;


            $db = new Model();
            $db->_tabela = $this->tableName;
            $where = $this->userColumn . "='" . $this->user . "' and " . $this->passColumn. "='" . $this->pass . "'";
            $sql = $db->read($where,'1');

            if( count($sql) > 0)
            {
                $this->sessionHelper->createSession("userAuth", true)
                    ->createSession("userData", $sql[0]);
                $login_status = 'success';
            }
            else
            {
                $login_status = 'invalid';
            }

            $resp['login_status'] = $login_status;

            echo (json_encode($resp));exit;
            //$this->redirectorHelper->goToControllerAction($this->loginController , $this->loginAction , true);

            return $this;
        }

        public function logout()
        {
            $this->sessionHelper->deleteSession("userAuth")
                                ->deleteSession("userData");

            $this->redirectorHelper->goToControllerAction($this->logoutController , $this->logoutAction , true);
            return $this;
        }

        public function checkLogin()
        {
            if (!$this->sessionHelper->checkSession("userAuth"))
            {
                //die($this->redirectorHelper->getCurrentController() .' <br/> '. $this->loginController.' <br/> '. $this->redirectorHelper->getCurrentAction() .' <br/> '. $this->loginAction);
                if( ( $this->redirectorHelper->getCurrentController() != $this->loginController ) || ($this->redirectorHelper->getCurrentAction() != $this->loginAction) )
                {
                    $this->redirectorHelper->goToControllerAction($this->loginController , $this->loginAction , true );
                }
            }
        }

        public function userData( $key )
        {
            $s = $this->sessionHelper->selectSession("userData");
            return $s[$key];
        }


    }