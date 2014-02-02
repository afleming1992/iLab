<?php
    error_reporting(E_ALL ^ E_NOTICE);
    session_start();

    function loadClass($className)
    {
        require_once 'classes/'.$className.'.class.php';
    }
    spl_autoload_register('loadClass');

    require_once('config/config.php');

    $db = new Database($server, $database, $user, $password, $table_prefix);

    require_once('controller/controller.php');