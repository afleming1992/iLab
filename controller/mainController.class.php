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

    public function loadAdminPage($action,$data = NULL)
    {
        $this->loadPageHeader();
        if($this->checkLoginandAccess(2))
        {
            if($action == "userList")
            {
                $users = array();
                $users = $this->getAllUsers($action);
            }
            else if($action == "editUser")
            {
                $user = $data;
            }
            include('content/adminContent.php');
        }
        $this->loadFooter();
    }

    public function loadProjectPage($id)
    {
        $project = new Project($this->getDb(),$id);
        if($project->getProject())
        {
            $this->loadPageHeader();
            $section = new Section($this->getDb(),3);
            $sideNav = $this->getNavController()->loadSideNavigation($section->getSectionId());
            $adminSection = $this->getNavController()->loadPageAdmin("project",$id);
            $admin = false;
            if(isset($_SESSION['username']))
            {
                $result = $this->getDb()->query("SELECT * FROM project_collaborator WHERE username = '".$_SESSION['username']."' AND projectId = '$id'");
                if($data = $result->fetch())
                {
                    if($data['admin'] == 1)
                    {
                        $admin = true;
                    }
                }
            }
            include('content/projectView.php');
            $this->loadFooter();
        }
        else
        {
            $this->pageNotFound();
        }
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

    public function loadEditProject($id)
    {
        $project = new Project($this->getDb(),$id);
        if($project->getProject())
        {
            $this->loadPageHeader();
            $result = "SELECT * FROM project_collaborator WHERE username = '".$_SESSION['username']."' AND admin = '1'";
            if($this->checkLoginAndAccess(1) || $data = $result->fetch())
            {
                $sections = $this->getAllSections($id);
                include("forms/editProject.php");
                $this->loadFooter();
            }
            else
            {
                $this->checkLoginandAccess(3); //This will send the user to Access Denied
            }
        }
    }

    public function editProject($id,$name,$description,$startDate,$endDate,$website,$newlogo)
    {
        $project = new Project($this->getDb(),$id);
        if($project->getProject())
        {
            $name = htmlspecialchars($name,ENT_QUOTES);
            $description = htmlspecialchars($description,ENT_QUOTES);
            $project->setName($name);
            $project->setDescription($description);
            $project->setStartDate($project->normalToSql($startDate));
            $project->setEndDate($project->normalToSql($endDate));
            $project->setWebsite($website);
            if($newlogo == "yes")
            {
                $allowedExts = array("gif", "jpeg", "jpg", "png");
                $temp = explode(".", $_FILES["project_logo"]["name"]);
                $extension = end($temp);
                if (($_FILES["project_photo"]["size"] < 1000000)
                    && in_array($extension, $allowedExts))
                {
                    if ($_FILES["profile_photo"]["error"] > 0)
                    {
                        echo "Return Code: " . $_FILES["project_logo"]["error"] . "<br>";
                    }
                    else
                    {
                        //echo "Upload: " . $_FILES["project_logo"]["name"] . "<br>";
                        //echo "Type: " . $_FILES["project_logo"]["type"] . "<br>";
                        //echo "Size: " . ($_FILES["project_logo"]["size"] / 1024) . " kB<br>";
                        //echo "Temp file: " . $_FILES["project_logo"]["tmp_name"] . "<br>";

                        //echo "images/project/" .$_FILES["project_logo"]["name"];
                        move_uploaded_file($_FILES["project_logo"]["tmp_name"],
                                           "images/project/" .$_FILES["project_logo"]["name"]);

                        $project->setLogo($_FILES["project_logo"]["name"]);
                    }
                }
                else
                {
                    echo "Invalid file";
                }
            }
            if($project->updateProject())
            {
                $this->loadProjectPage($project->getId());
            }
            else
            {
                $error = "The Project has not been updated on the Database. Please retry again!";
                $this->loadPageHeader();
                include("forms/editProject.php");
                $this->loadPageFooter();
            }
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

    public function createUser($username,$realname,$email,$access,$password,$hidden)
    {
        $user = new User($this->getDb(),$username);
        $user->getProfile()->setRealName($realname);
        $user->getProfile()->setEmail($email);
        $user->setAccessLevel($access);
        $user->setPassword($password);
        $user->setHidden($hidden);
        if($user->createUser())
        {
            $this->loadUpdateStatus("<div class='alert alert-success'><h3>$username has been created successfully</h3></div><a class='btn btn-primary' href='?mode=admin&action=userList'>Go to User List</a>");
        }
        else
        {
            $this->loadUpdateStatus("<div class='alert alert-danger'><h3>Oh Dear! The user wasn't created!</h3></div>");
        }
    }

    public function editUser($admin,$username,$realname,$email,$access,$newpassword,$password,$hidden,$role,$website,$bio,$pureId,$twitter,$scholar,$linkedin,$newphoto,$photolink)
    {
        if($newphoto == "yes")
        {
            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["profile_photo"]["name"]);
            $extension = end($temp);
            if (($_FILES["profile_photo"]["size"] < 1000000)
                && in_array($extension, $allowedExts))
            {
                if ($_FILES["profile_photo"]["error"] > 0)
                {
                    echo "Return Code: " . $_FILES["profile_photo"]["error"] . "<br>";
                }
                else
                {
                    //echo "Upload: " . $_FILES["profile_photo"]["name"] . "<br>";
                    //echo "Type: " . $_FILES["profile_photo"]["type"] . "<br>";
                    //echo "Size: " . ($_FILES["profile_photo"]["size"] / 1024) . " kB<br>";
                    //echo "Temp file: " . $_FILES["profile_photo"]["tmp_name"] . "<br>";


                        move_uploaded_file($_FILES["profile_photo"]["tmp_name"],
                                           "images/profile/" . $username .".". $extension);
                        $photolink = $username.".".$extension;
                }
            }
            else
            {
                echo "Invalid file";
            }
        }
        $user = new User($this->getDb(),$username);
        $user->getUser();
        $user->getProfile()->getProfile();

        $user->getProfile()->setRealName($realname);
        $user->getProfile()->setEmail($email);
        $user->getProfile()->setRole($role);
        $user->getProfile()->setWebsite($website);
        $user->getProfile()->setBio(htmlspecialchars($bio,ENT_QUOTES));
        $user->getProfile()->setPureId($pureId);
        $user->getProfile()->setTwitter($twitter);
        $user->getProfile()->setScholar($scholar);
        $user->getProfile()->setLinkedIn($linkedin);

        if($newphoto == "yes")
        {
            $user->getProfile()->setPhoto($photolink);
        }

        if($admin == 1)
        {
            $user->setAccessLevel($access);
            $user->setHidden($hidden);
        }

        if($newpassword == "yes")
        {
            $user->updatePassword($password);
        }

        if($user->updateUser())
        {
            if($admin == 1)
            {
                $this->loadAdminPage("userList");
            }
            else
            {
                $this->loadUpdateStatus("<div class='alert alert-success'>Your Account has been updated!</div>");
            }
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

    public function loadUpdateStatus($message)
    {
        $this->loadPageHeader();
        include('content/creationSuccess.php');
        $this->loadFooter();
        exit();
    }

    public function loadProjectList($past)
    {
        $this->loadPageHeader();
        $projects = array();
        $sideNav = $this->getNavController()->loadSideNavigation(3);
        $adminSection = $this->getNavController()->loadPageAdmin($_GET['mode'],NULL);
        $projects = $this->getAllProjects($past);
        include('content/projectList.php');
        $this->loadFooter();
    }


    public function loadSponsorsList($projectId)
    {
        $sponsors = array();
        $project = new Project ($this->getDb(),$projectId);
        if($project->getProject())
        {
            $sponsors = $project->findSponsorsAndPartners();
            $fullSponsorList = $this->getAllSponsors();
            if($_SESSION['access_level'] > 0 || $project->checkIfAdmin($_SESSION['username']))
            {
                $this->loadPageHeader();
                include("content/manageProjectSponsors.php");
                $this->loadFooter();
            }
            else
            {
                $this->loadAccessDenied();
            }
        }
        else
        {
            $this->pageNotFound();
        }
    }

    public function getAllSponsors()
    {
        $sponsors = array();
        $result = $this->getDb()->query("SELECT * FROM sponsor");
        if($result)
        {
            while($data = $result->fetch())
            {
                $sponsor = new Sponsor($this->getDb(),$data['sponsorId']);
                if($sponsor->getSponsor())
                {
                    $sponsors[] = $sponsor;
                }
            }
        }
        return $sponsors;
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

    public function loadCreateUser()
    {
        $this->loadPageHeader();
        if($this->checkLoginandAccess(2))
        {
            include("forms/addUser.php");
        }
        $this->loadFooter();
    }

    public function loadEditUser($mode,$username)
    {
        if($mode == "admin")
        {
            $user = new User($this->getDb(),$username);
            $user->getUser();
            $user->getProfile()->getProfile();
            $this->loadAdminPage("editUser",$user);
        }
        else
        {
            $user = new User($this->getDb(),$username);
            $this->loadPageHeader();
            include("forms/editUser.php");
            $this->loadFooter();
        }
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

    public function getAllProjects($past)
    {
        if($past == 1)
        {
            $where = "endDate < CURDATE()";
        }
        else
        {
            $where = "endDate > CURDATE()";
        }
        $result = $this->getDb()->query("SELECT * FROM project WHERE ".$where);
        $projects = array();
        if($result)
        {
            while($data = $result->fetch())
            {
                $project = new Project($this->getDb(),$data['projectId']);
                $project->getProject();
                $projects[] = $project;
            }
        }
        return $projects;
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

    public function getAllUsers()
    {
        $result = $this->getDb()->query("SELECT * FROM user");
        $users = array();
        while($data = $result->fetch())
        {
            $user = new User($this->getDb(),$data['username']);
            $user->getUser();
            $user->getProfile()->getProfile();
            $users[] = $user;
        }
        return $users;
    }

    public function addSponsorLink($sponsorId,$projectId,$type)
    {
        $sponsor = new Sponsor($this->getDb(),$sponsorId);
        if($sponsor->getSponsor())
        {
            if($sponsor->addLink($projectId,$type))
            {
                $success = $sponsor->getName()."added to project as a ".$type;
            }
            else
            {
                $error = "Link couldn't be added";
            }
        }
        else
        {
            $error = "Couldn't find Sponsor in Database";
        }
        $this->loadSponsorsList($projectId);
    }

    public function removeSponsorLink($sponsorId,$projectId)
    {
        $sponsor = new Sponsor($this->getDb(),$sponsorId);
        if($sponsor->getSponsor())
        {
            if($sponsor->removeLink($projectId))
            {
                $success = $sponsor->getName()."has been removed from this project!";
            }
        }
        else
        {
            $error = "Sponsor Link wasn't removed!";
        }
        $this->loadSponsorsList($projectId);
    }

    public function upload($file,$directory,$fileName)
    {
        $allowedExts = array("gif", "jpeg", "jpg", "png","pdf");
        $temp = explode(".", $file["name"]);
        $extension = end($temp);
        if (($file["size"] < 1000000) && in_array($extension, $allowedExts))
        {
            if ($file["error"] > 0)
            {
                 echo "Return Code: " . $file["error"] . "<br>";
            }
            else
            {
                //echo "Upload: " . $_FILES["profile_photo"]["name"] . "<br>";
                //echo "Type: " . $_FILES["profile_photo"]["type"] . "<br>";
                //echo "Size: " . ($_FILES["profile_photo"]["size"] / 1024) . " kB<br>";
                //echo "Temp file: " . $_FILES["profile_photo"]["tmp_name"] . "<br>";
                move_uploaded_file($file["tmp_name"],$directory.$fileName);
            }
        }
        else
        {
            echo "Invalid file";
        }
    }

    /**
     * @param mixed $db
     */
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