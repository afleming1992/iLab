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

        unset($_COOKIE['access_key']);
        setcookie('access_key',time()-3600);
        $loggedout = 1;
    }

    if(!isset($_SESSION['username']) && isset($_COOKIE['access_key']))
    {
        $username = $app->checkCookie($_COOKIE['access_key']);
        if($username != false)
        {
            $user = new User($db,$username);
            $user->getUser();
            $_SESSION['login'] = true;
            $_SESSION['username'] = $user->getUsername();
            $_SESSION['access_level'] = $user->getAccessLevel();
        }
    }

    //Form Handling
    if(isset($_POST['createPage']))
    {
        $section = new Section($db,$_POST['page_section']);
        $section->getDetails();
        if($section->getRestricted() == 1)
        {
            $restricted = 1;
        }
        else
        {
            $restricted = $_POST['restricted'];
        }
        $app->createNewPage($_POST['page_title'],$_POST['page_section'],$_POST['page_content'],$_POST['page_module'],$restricted,$_POST['page_homepage']);
    }

    if(isset($_POST['editPage']))
    {
        if(isset($_POST['page_homepage']))
        {
            $homepage = $_POST['page_homepage'];
        }
        else
        {
            $homepage = false;
        }

        $section = new Section($db,$_POST['page_section']);
        $section->getDetails();
        if($section->getRestricted() == 1)
        {
            $restricted = 1;
        }
        else
        {
            $restricted = $_POST['restricted'];
        }

        $message = $app->editPage($_POST['page_id'],$_POST['page_title'],$_POST['page_section'],$_POST['page_content'],$_POST['page_module'],$restricted,$_POST['page_homepage']);
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

    if(isset($_POST['createPublication']))
    {
        if($_POST['file_choice'] == "file")
        {
            $location = $app->upload($_FILES['publication_file'],"uploads/publications/",$_FILES['publication_file']['name']);
        }
        else if($_POST['file_choice'] == "link")
        {
            $location = $_POST['publication_link'];
        }
        else
        {
            $location = "";
        }
        $app->createPublication($_POST['publication_title'],$_POST['publication_publishedIn'],$_POST['publication_publisher'],$_POST['publication_abstract'],$_POST['publication_year'],$location);
        exit();
    }

    if(isset($_POST['editPublication']))
    {
        if($_POST['file_choice'] == "yes")
        {
            $location = $app->upload($_FILES['publication_file'],"uploads/publications/",$_FILES['publication_file']['name']);
        }
        else
        {
            $location = $_POST['link'];
        }

        $publication = new Publication($db,$_POST['publicationId']);
        if($publication->getPublication())
        {
            $publication->setName(htmlentities($_POST['title'],ENT_QUOTES));
            $publication->setPublishedIn(htmlentities($_POST['publishedIn'],ENT_QUOTES));
            $publication->setPublisher(htmlentities($_POST['publisher'],ENT_QUOTES));
            $publication->setYear($_POST['year']);
            $publication->setAbstract(htmlentities($_POST['abstract'],ENT_QUOTES));
            $publication->setLink($location);
            if($publication->updatePublication())
            {
                $app->loadPublication($publication->getId());
                exit();
            }
            else
            {
                $app->loadUpdateStatus("<div class='alert alert-danger'>Couldn't Update Publication</div>");
            }
        }
    }

    if(isset($_POST['addPubProject']))
    {
        $publication = new Publication($db,$_POST['publicationId']);
        if($publication->getPublication())
        {
            if($publication->addProject($_POST['project']))
            {
                $app->loadPubProjectList($_POST['publicationId']);
                exit();
            }
        }
        else
        {
            $app->loadUpdateStatus("<div class='alert alert-danger'>Couldn't find Publication</div>");
            exit();
        }
    }

    if(isset($_POST['addAuthor']))
    {
        $publication = new Publication($db,$_POST['publicationId']);
        if($publication->getPublication())
        {
            if($_POST['author_choice'] == "yes")
            {
                if($publication->addIlabAuthor($_POST['ilab_author']))
                {
                    $app->loadAuthorList($_POST['publicationId']);
                }
                else
                {
                    $app->loadUpdateStatus("<div class='alert alert-danger'>Couldn't add Author</div>");
                }
            }
            else
            {
                if($publication->addAuthor($_POST['non_author']))
                {
                    $app->loadAuthorList($_POST['publicationId']);
                }
                else
                {
                    $app->loadUpdateStatus("<div class='alert alert-danger'>Couldn't add Author for some reason</div>");
                }
            }
        }
        else
        {
            $app->pageNotFound();
        }
        exit();
    }
    if(isset($_POST['createProject']))
    {
        $project = new Project($db,0);
        $project->setName(htmlentities($_POST['project_name'],ENT_QUOTES));
        $project->setDescription(htmlentities($_POST['project_description'],ENT_QUOTES));
        $project->setWebsite($_POST['project_website']);
        $project->setStartDate($project->normalToSql($_POST['project_startDate']));
        $project->setEndDate($project->normalToSql($_POST['project_endDate']));
        $fileLink = $_FILES['project_logo']['name'];
        $app->upload($_FILES['project_logo'],"images/project/",$fileLink);
        $project->setLogo($fileLink);
        if($project->createProject())
        {
            $app->addContributorToProject($project->getId(),$_SESSION['username'],1,0);
            $app->redirect("?mode=project&id=".$project->getId());
        }
        else
        {
            $app->loadUpdateStatus("<div class='alert alert-danger'>Project could not be added!</div>");
        }
    }
    if(isset($_POST['createNews']))
    {
        $news = new News($db,0);
        $news->setTitle(htmlentities($_POST['title'],ENT_QUOTES));
        $news->setSummary(htmlentities($_POST['summary'],ENT_QUOTES));
        $news->setContent(htmlentities($_POST['article'],ENT_QUOTES));
        $news->setAuthor(new Profile($db,$_SESSION['username']));
        $fileLink = $_FILES['news_image']['name'];
        $app->upload($_FILES['news_image'],"images/news/",$fileLink);
        $news->setImage($fileLink);
        if($news->createNews())
        {
            $app->redirect("?mode=news&id=".$news->getId());
        }
        else
        {
            $app->loadUpdateStatus("<div class='alert alert-danger'>failed to add News!</div>");
        }
    }
    if(isset($_POST['editNews']))
    {
        $news = new News($db,$_POST['newsId']);
        if($news->getNews())
        {
            $news->setTitle(htmlentities($_POST['title'],ENT_QUOTES));
            $news->setSummary(htmlentities($_POST['summary'],ENT_QUOTES));
            $news->setContent(htmlentities($_POST['article'],ENT_QUOTES));
            $news->setAuthor(new Profile($db,$_SESSION['username']));
            if($_POST['image_choice'] == "yes")
            {
                $fileLink = $_FILES['news_image']['name'];
                $app->upload($_FILES['news_image'],"images/news/",$fileLink);
                $news->setImage($fileLink);
            }

            if($news->updateNews())
            {
                echo "Success";
                //$app->redirect("?mode=news&id=".$news->getId());
            }
        }
    }

    //Page Loading
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
        if(strcmp($mode,"profile") == 0)
        {
            if(isset($_GET['user']))
            {
                $app->loadProfile($_GET['user']);
                exit();
            }
            else
            {
                $app->loadStaffList();
                exit();
            }
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
        else if(strcmp($mode,"publication") == 0)
        {
            if(isset($_GET['id']))
            {
                $app->loadPublication($_GET['id']);
            }
            else
            {
                $app->loadPublicationList();
            }
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
                else if(strcmp($_GET['type'],"author") == 0)
                {
                    $app->loadAuthorList($_GET['id']);
                }
                else if(strcmp($_GET['type'],"pub_project") == 0)
                {
                    $app->loadPubProjectList($_GET['id']);
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
        else if(strcmp($mode,"news") == 0)
        {
            if(isset($_GET['id']))
            {
                $app->loadNews($_GET['id']);
            }
            else
            {
                $app->loadNewsList();
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
                else if(strcmp($_GET['type'],"publication") == 0)
                {
                    $app->loadCreatePublication();
                }
                else if(strcmp($_GET['type'],"project") == 0)
                {
                    $app->loadCreateProject();
                }
                else if(strcmp($_GET['type'],"news") == 0)
                {
                    $app->loadCreateNews();
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
                else if(strcmp($_GET['type'],"publication") == 0)
                {
                    $app->loadEditPublication($_GET['id']);
                }
                else if(strcmp($_GET['type'],"news") == 0)
                {
                    $app->loadEditNews($_GET['id']);
                }
            }
            else
            {
                $app->pageNotFound();
            }
        }
        else if(strcmp($mode,"delete") == 0)
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
            else if($_GET['type'] == "publication")
            {
                $publication = new Publication($db,$_GET['id']);
                if($publication->deletePublication())
                {
                    $app->loadPublicationList();
                }
            }
            else if($_GET['type'] == "page")
            {
                $page = new Page($db,$_GET['id']);
                if($page->deletePage())
                {
                    $app->loadUpdateStatus("<div class='alert alert-success'>The page has been deleted!</div>");
                }
                else
                {
                    $app->loadUpdateStatus("<div class='alert alert-danger'>The System was unable to delete the page! Here is what could of happened:- <ul><li>The Page was a Section Homepage and therefore couldn't be deleted</li><li>There may have been a database error!</li><li>The page has been deleted already</li></ul></div>");
                }
            }
            else if($_GET['type'] == "author")
            {
                $result = $db->query("DELETE FROM ".$db->getPrefix()."publication_author WHERE authorId = '".$_GET['id']."'");
                if($result)
                {
                    $app->loadAuthorList($_GET['pubId']);
                }
                else
                {
                    $app->loadUpdateStatus("<div class='alert alert-danger'>Couldn't remove Author</div>");
                }
            }
            else if($_GET['type'] == "pub_project")
            {
                $publication = new Publication($db,$_GET['pub_id']);
                if($publication->removeProject($_GET['id']))
                {
                    $app->loadPubProjectList($_GET['pub_id']);
                }
                else
                {
                    $app->loadUpdateStatus("<div class='alert alert-danger'>Couldn't remove the Project</div>");
                }
                exit();
            }
            else if($_GET['type'] == "project")
            {
                $project = new Project($db,$_GET['id']);
                if($project->deleteProject())
                {
                    $app->redirect("?mode=project");
                    exit();
                }
            }
            else if($_GET['type'] == "news")
            {
                $news = new News($db,$_GET['id']);
                if($news->deleteNews())
                {
                    $app->redirect("?mode=news");
                    exit();
                }
            }
            else
            {
                $app->pageNotFound();
            }
        }
        else if(strcmp($mode,"reorder") == 0)
        {
            $app->reorder($_GET['id'],$_GET['direction']);
        }
        else if(strcmp($mode,"admin") == 0)
        {
            if($_GET['action'] == "editUser")
            {
              $app->loadEditUser($_GET['mode'],$_GET['id']);
            }
            else if($_GET['action'] == "deleteUser")
            {
                if($app->checkLoginandAccess(2))
                {
                    $user = new User($db,$_GET['id']);
                    if($user->deleteUser())
                    {
                        $app->redirect("?mode=admin&action=userList");
                    }
                }
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

