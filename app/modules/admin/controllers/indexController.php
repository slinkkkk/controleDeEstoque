<?php

Class Index extends Controller
{
    public $upar, $redirect;

    public function index_action()
    {
        $this->view("index");
    }
}