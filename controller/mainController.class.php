<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 01/02/14
 * Time: 22:14
 */

class mainController
{
    private $db;
    private $navController;

    public function __construct($db)
    {
        $this->setDb($db);
        $this->navController = new navController($this->db);
    }

    public function login($username, $password)
    {
        $user = new User($this->getDb(),$username,$password);
        if($user->checkPassword())
        {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $user->getUsername();
            $_SESSION['access_level'] = $user->getAccessLevel();
            $this->loadLoginSuccessful();
        }
        else
        {
            $this->loadLoginFailure($username);
        }
    }

    public function loadLoginSuccessful()
    {
        $this->loadPageHeader();
        include("content/loginSuccess.php");
        $this->loadFooter();
    }

    public function loadLoginFailure($username)
    {
        $this->loadPageHeader();
        print("<div class='alert alert-danger'><b>Login Not Successful</b> Please try again!</div>");
        include('forms/login.php');
        $this->loadFooter();
    }

    //Page Loaders
    public function loadHomePage()
    {
        $this->loadPageHeader();
        include('content/homepage.php');
        $this->loadFooter();
    }

    public function loadContentPage($id)
    {
        $this->loadPageHeader();
        $page = new Page($this->getDb(),$id);
        if($page->getPageDetails())
        {
            if(!$page->getRestricted() || ($page->getRestricted() && isset($_SESSION['login'])))
            {
                $section = $page->getSection()->getSectionId();
                $sideNav = $this->getNavController()->loadSideNavigation($section);
                $adminSection = $this->getNavController()->loadPageAdmin($_GET['mode'],$id);
                include('content/content.php');
            }
            else
            {
                $this->loadLoginRequired();
            }
        }
        else
        {
            $this->contentNotFound();
        }
        $this->loadFooter();
    }

    public function loadCreatePage()
    {
        $result = $this->getDb()->query("SELECT * FROM section");
        $sections = "";
        if($result)
        {
            while($data = $result->fetch())
            {
                $sections .= "<option value='".$data['section_id']."'>".$data['name']."</option>";
            }
        }
        $this->loadPageHeader();
        include("forms/editPage.php");
        $this->loadFooter();
    }

    //Part Loaders
    public function loadLoginRequired()
    {
        echo "<div class='alert alert-warning'><h3>Sorry!</h3> This page is restricted to iLab staff only! Please login to confirm your identidy!</div>";
        include('forms/login.php');
    }

    public function loadPageHeader()
    {
        $navigation = $this->getNavController()->loadMainNavigation();
        include('content/header.php');
    }

    public function contentNotFound()
    {
        include('content/404.php');
    }

    public function loadFooter()
    {
        include('content/footer.php');
    }

    public function pageNotFound()
    {
        $this->loadPageHeader();
        $this->contentNotFound();
        $this->loadFooter();
    }

    /**
     * @param mixed $db
     */

    //Getters / Setters
    public function setDb($db)
    {
        $this->db = $db;
    }

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param mixed $navController
     */
    public function setNavController($navController)
    {
        $this->navController = $navController;
    }

    /**
     * @return mixed
     */
    public function getNavController()
    {
        return $this->navController;
    }




} 