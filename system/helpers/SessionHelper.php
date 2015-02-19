<?php
/**
 * Created by PhpStorm.
 * User: MAURÍCIO
 * Date: 11/12/2014
 * Time: 16:01
 */

    class SessionHelper {

        public function createSession ( $name , $value )
        {
            $_SESSION[$name] = $value;
            return $this;
        }

        public function selectSession ( $name )
        {
            return $_SESSION[$name];
        }

        public function deleteSession ( $name )
        {
            unset ( $_SESSION[$name] ) ;
            return $this;
        }

        public function checkSession ( $name )
        {
            return isset( $_SESSION[$name] );
        }

    }