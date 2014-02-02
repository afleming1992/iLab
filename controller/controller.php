<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 01/02/14
 * Time: 21:48
 */

    require_once('controller/mainController.class.php');

    $app = new MainController($db);

    if(isset($_GET['mode']))
    {
        $mode = $_GET['mode'];
        //Do Exit at the end of each Control Function
    }
    else
    {
        //Load Homepage
        $app->loadHomepage();
    }

