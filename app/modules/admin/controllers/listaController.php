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
        $this->view("index");
    }

    public function menu()
    {
        $this->view("menu");
    }

    public function cadastrar()
    {
        $redirect = new RedirectorHelper();
        $redirect->goToAction("index",true);
    }
}