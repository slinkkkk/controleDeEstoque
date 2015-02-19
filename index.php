<?php
    session_start();

    define( 'SITE','app/modules/default' );
    define( 'ADMIN','app/modules/admin' );
    define( 'LAYOUT','app/layout' );

    define( 'MODELS', 'app/models/' );
    define( 'HELPERS', 'system/helpers/' );

    define( 'TEMANEON', '/public/tema/neon/');


    require_once('system/system.php');
    require_once('system/controller.php');
    require_once('system/model.php');


    function __autoload( $file ){
        if ( file_exists(MODELS . $file . '.php') )
            //die(MODELS  . $file. '.php');
            require_once( MODELS . $file . '.php' );
        else if ( file_exists(HELPERS . $file . '.php') )
            require_once( HELPERS . $file . '.php' );
        else
            die("Model ou Helper nao encontrado.");
    }

    $start = new System;
    $start->run();

