<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 01/02/14
 * Time: 21:48
 */

    require_once('controller/mainController.class.php');
    require_once('controller/navController.class.php');
    $app = new MainController($db);

    if(isset($_GET['logout']) && $_GET['logout'] == 1)
    {
        unset($_SESSION['username']);
        unset($_SESSION['access_level']);
        unset($_SESSION['login']);
        $loggedout = 1;
    }

    if(isset($_GET['mode']))
    {
        $mode = $_GET['mode'];
        //Do Exit at the end of each Control Function
        if(strcmp($mode,"content") == 0)
        {
            $app->loadContentPage($_GET['id']);
            exit();
        }
        else if(strcmp($mode,"login") == 0)
        {
            if(isset($_POST['login']))
            {
                $app->login($_POST['login_username'],$_POST['login_password']);
            }
            else
            {
                //$app->loadLogin();
                exit();
            }
        }
    }
    else
    {
        //Load Homepage
        $app->loadHomepage();
    }

