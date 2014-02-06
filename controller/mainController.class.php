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
        $user = new User($this->getDb(),$username);
        $user->setPassword($password);
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

    public function loadEditPage($id)
    {
        $page = new Page($this->getDb(),$id);
        if($page->getPageDetails())
        {
            $this->loadPageHeader();
            if($this->checkLoginandAccess(2))
            {
                $sections = $this->getAllSections($id);
                include("forms/editPage.php");
            }
            $this->loadFooter();
        }
        else
        {
            $this->pageNotFound();
        }
    }

    public function createNewPage($title,$section,$content,$module,$restricted)
    {
        $title = htmlspecialchars($title,ENT_QUOTES);
        $content = htmlspecialchars($content,ENT_QUOTES);
        $page = new Page($this->getDb(),0);
        $page->setTitle($title);
        $page->setSection(new SectionInfo($this->getDb(),$section));
        $page->setAuthor(new Profile($this->getDb(),$_SESSION['username']));
        $page->setRestricted($restricted);
        $page->setContent($content);
        $page->setModule($module);
        if($page->createPage())
        {
           $this->redirect("?mode=content&id=".$page->getPageId());
        }
        else
        {
            echo "<div class='alert alert-danger'><h3>Oh No!</h3>Looks like there was a problem...</div>";
        }
    }

    public function editPage($pageId,$title,$section,$content,$module,$restricted)
    {
        $page = new Page($this->getDb(),$pageId);
        if($page->getPageDetails())
        {
            $title = htmlspecialchars($title,ENT_QUOTES);
            $content = htmlspecialchars($content,ENT_QUOTES);
            $page->setTitle($title);
            $page->setSection(new SectionInfo($this->getDb(),$section));
            $page->setAuthor(new Profile($this->getDb(),$_SESSION['username']));
            $page->setRestricted($restricted);
            $page->setContent($content);
            $page->setModule($module);
            if($page->updatePage())
            {
                $this->redirect("?mode=content&id=".$page->getPageId());
            }
            else
            {
                echo "<div class='alert alert-danger'><h3>Oh No!</h3>Looks like there was a problem...</div>";
            }
        }
        else
        {
            $this->pageNotFound();
        }
    }

    public function redirect($url)
    {
        ?>
            <script>
                window.location = "index.php<?php echo $url; ?>"
            </script>
        <?php
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
        $this->loadPageHeader();
        if($this->checkLoginandAccess(2))
        {
            $sections = $this->getAllSections(0);
            include("forms/editPage.php");
        }
        $this->loadFooter();
    }

    public function getAllSections($id)
    {
        $result = $this->getDb()->query("SELECT * FROM section");
        $sections = "";
        if($result)
        {
            while($data = $result->fetch())
            {
                $sections .= "<option value='".$data['section_id']."'";
                if($data['section_id'] == $id)
                {
                    $sections .= "selected";
                }
                $sections .= ">".$data['name']."</option>";
            }
        }
        return $sections;
    }

    public function checkLoginandAccess($levelRequired)
    {
        if(isset($_SESSION['login']))
        {
            $user = new User($this->getDb(),$_SESSION['username']);
            $user->getUser();
            if($user->getAccessLevel() >= $levelRequired)
            {
                return true;
            }
            else
            {
                $this->loadAccessDenied();
            }
        }
        else
        {
            $this->loadLoginRequired();
            return false;
        }
    }

    //Part Loaders
    public function loadLoginRequired()
    {
        $verification = true;
        echo "<div class='alert alert-warning'><h3>Sorry!</h3> This page is restricted to iLab staff only! Please login to confirm your identidy!</div>";
        include('forms/login.php');
    }

    public function loadAccessDenied()
    {
        $this->loadPageHeader();
        include('content/accessDenied.php');
        $this->loadFooter();
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