<?php

/**
 * Created by PhpStorm.
 * User: MAURÍCIO
 * Date: 12/12/2014
 * Time: 02:09
 */
Class Login extends Controller
{

    public function index_action()
    {
        $redirection = new RedirectorHelper();
        $redirection->goToAction("logar", true);
    }

    public function logar()
    {
        if ($this->getParam("log")) {
            // Fields Submitted
            $login = htmlspecialchars($_POST["username"], ENT_QUOTES);
            $senha = htmlspecialchars($_POST["password"], ENT_QUOTES);

            $authHelper = new AuthHelper();
            $authHelper
                ->setTableName("usuarios")
                ->setUserColumn("login")
                ->setPassColumn("senha")
                ->setUser($login)
                ->setPass(md5($senha))
                ->login();
        }

        $this->login();
    }

    public function sair()
    {
        $auth = new AuthHelper();
        $auth->setLogoutControllerAction("login", "logar")
            ->logout();
    }
}