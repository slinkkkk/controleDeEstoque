<?php

Class Index extends Controller
{
    public  $redirect;

    public function index_action()
    {
        $this->redirect = new RedirectorHelper();
        $this->redirect->goToControllerAction("lista","menu",true);
    }
}