<?php

Class Index extends Controller
{
    public  $redirect;

    public function index_action()
    {
        $this->view("index");
    }
}