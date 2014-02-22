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
        $message = $app->editPage($_POST['page_id'],$_POST['page_title'],$_POST['page_section'],$_POST['page_content'],$_POST['page_module'],$_POST['page_restricted']);
    }

    if(isset($_POST['addUser']))
    {
        $message = $app->createUser($_POST['user_username'],$_POST['user_realname'],$_POST['user_email'],$_POST['user_access'],$_POST['user_password1'],$_POST['user_hidden'],$_POST['']);
    }

    if(isset($_POST['editUser']))
    {
        $admin = 0;
        if(isset($_POST['admin']))
        {
            $admin = 1;
        }
        $app->editUser($admin,$_POST['username'],$_POST['profile_realname'],$_POST['profile_email'],$_POST['access_level'],$_POST['choose_password'],$_POST['new_password1'],$_POST['user_hidden'],$_POST['profile_role'],$_POST['profile_website'],$_POST['profile_bio'],$_POST['profile_pure'],$_POST['profile_twitter'],$_POST['profile_scholar'],$_POST['profile_linkedin'],$_POST['new_photo'],$_POST['profile_photo']);
        exit();
    }

    if(isset($_POST['addCollaborator']))
    {
        $app->addContributorToProject($_POST['projectId'],$_POST['collaborator_username'],$_POST['collaborator_admin'],$_POST['collaborator_hidden']);
        exit();
    }

    if(isset($_POST['editProject']))
    {
        $app->editProject($_POST['project_id'],$_POST['project_name'],$_POST['project_description'],$_POST['project_startDate'],$_POST['project_endDate'],$_POST['project_website'],$_POST['new_logo']);
        exit();
    }

    if(isset($_POST['editSponsor']))
    {
        $app->editSponsor($_POST['sponsor_id'],$_POST['sponsor_name'],$_POST['sponsor_website'],$_POST['new_photo'],$_FILES['sponsor_logo'],$_POST['project']);
        exit();
    }

    if(isset($_POST['addSponsor']))
    {
        $sponsor = new Sponsor($db->getDb(),0);
        $sponsor->setName($_POST['sponsor_name']);
        $sponsor->setWebsite($_POST['sponsor_website']);
        $fileName = $_FILES['sponsor_logo']['name'];
        $app->upload($_FILES['sponsor_logo'],"images/sponsor/",$fileName);
        $sponsor->setLogo($fileName);
        if($sponsor->createSponsor())
        {
            $sponsor->addLink($_POST['projectId'],$_POST['sponsor_type']);
        }
    }

    if(isset($_POST['addExistingSponsor']))
    {
        $sponsor = new Sponsor($db->getDb(),$_POST['sponsorId']);
        if($sponsor->getSponsor())
        {
            $sponsor->addLink($_POST['projectId'],$_POST['sponsor_type']);
        }
    }

    if(isset($_GET['mode']))
    {
        $mode = $_GET['mode'];
        //Do Exit at the end of each Control Function
        if(strcmp($mode,"changeSponsorType") == 0)
        {
            $sponsor = new Sponsor($db->getDb(),$_GET['sponsorId']);
            if($sponsor->getSponsor())
            {
                $sponsor->switchType($_GET['projectId']);
            }
            $app->loadSponsorsList($_GET['projectId']);
            exit();
        }
        if(strcmp($mode,"content") == 0)
        {
            //View Standard Content Page Mode
            $app->loadContentPage($_GET['id']);
            exit();
        }
        if(strcmp($mode,"project") == 0)
        {
            if(isset($_GET['id']))
            {
                $app->loadProjectPage($_GET['id']);
            }
            else
            {
                if(isset($_GET['past']))
                {
                    $past = 1;
                }
                else
                {
                    $past = 0;
                }
                $app->loadProjectList($past);
            }
            exit();
        }
        else if(strcmp($mode,"manage") == 0)
        {
            if(isset($_GET['type']))
            {
                if(strcmp($_GET['type'],"sponsor") == 0)
                {
                    $app->loadSponsorsList($_GET['id']);
                }
                else if(strcmp($_GET['type'],"collaborator") == 0)
                {
                    $app->loadCollaboratorsList($_GET['id']);
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
                else if(strcmp($_GET['type'],"user") == 0)
                {
                    $app->loadEditUser(NULL,$_SESSION['username']);
                }
                else if(strcmp($_GET['type'],"project") == 0)
                {
                    $app->loadEditProject($_GET['id']);
                }
                else if(strcmp($_GET['type'],"sponsor") == 0)
                {
                    $app->loadEditSponsor($_GET['id']);
                }
            }
            else
            {
                $app->pageNotFound();
            }
        }
        else if(strcmp($mode,"remove") == 0)
        {
            if($_GET['type'] == "sponsorLink")
            {
                $app->removeSponsorLink($_GET['sponsorId'],$_GET['projectId']);
            }
            else if($_GET['type'] == "collaborator")
            {
                $app->removeContributorFromProject($_GET['projectId'],$_GET['username']);
                exit();
            }
        }
        else if(strcmp($mode,"admin") == 0)
        {
            if($_GET['action'] == "editUser")
            {
              $app->loadEditUser($_GET['mode'],$_GET['id']);
            }
            else
            {
                $app->loadAdminPage($_GET['action']);
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

