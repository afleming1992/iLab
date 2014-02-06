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

    //Form Handling
    if(isset($_POST['createPage']))
    {
        $app->createNewPage($_POST['page_title'],$_POST['page_section'],$_POST['page_content'],$_POST['page_module'],$_POST['page_restricted']);
    }

    if(isset($_POST['editPage']))
    {
        $app->editPage($_POST['page_id'],$_POST['page_title'],$_POST['page_section'],$_POST['page_content'],$_POST['page_module'],$_POST['page_restricted']);
    }

    if(isset($_GET['mode']))
    {
        $mode = $_GET['mode'];
        //Do Exit at the end of each Control Function
        if(strcmp($mode,"content") == 0)
        {
            //View Standard Content Page Mode
            $app->loadContentPage($_GET['id']);
            exit();
        }
        else if(strcmp($mode,"login") == 0)
        {
            //Login Mode
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
        else if(strcmp($mode,"create") == 0)
        {
            if(isset($_GET['type']))
            {
                if(strcmp($_GET['type'],"page") == 0)
                {
                    $app->loadCreatePage();
                }
                else
                {
                    $app->pageNotFound();
                }
            }
        }
        else if(strcmp($mode,"edit") == 0)
        {
            //Edit Mode
            if(isset($_GET['type']))
            {
                if(strcmp($_GET['type'],"page") == 0)
                {
                    if(isset($_GET['id']))
                    {
                        $app->loadEditPage($_GET['id']);
                    }
                    else
                    {
                        $app->pageNotFound();
                    }
                }
            }
            else
            {
                $app->pageNotFound();
            }
        }
        else
        {
            $app->pageNotFound();
        }
    }
    else
    {
        //Load Homepage
        $app->loadHomepage();
    }

