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
            $user = new User($this->getDb(), $username);
            $user->setPassword($password);
            if ($user->checkPassword()) {
                $_SESSION['login'] = true;
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['access_level'] = $user->getAccessLevel();
                if($_POST['remember'])
                {
                    $string = $_SESSION['username']."-".date("c");
                    $accessKey = md5($string);
                    //Sets a cookie to expire in a year
                    $year = time()+60*60*24*365;
                    setcookie("access_key",$accessKey,$year);
                    $user->createAccessCookie($accessKey);
                }
                $this->redirect("?mode=profile&user=".$_SESSION['username']);
            } else {
                $this->loadLoginFailure($username);
            }
        }

        public function checkCookie($access_key)
        {
            $result = $this->getDb()->query("SELECT username FROM cookie WHERE keycode = '".$access_key."'");
            if($result)
            {
                $row = $result->fetch();
                return $row['username'];
            }
            else
            {
                return false;
            }
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
            $projects = $this->loadRandomProjects();
            $users = $this->loadRandomUsers();
            $publications = $this->loadLatestPublications();
            $articles = $this->loadLatestNews();
            include('content/homepage.php');
            $this->loadFooter();
        }

        public function loadAdminPage($action, $data = NULL)
        {
            $this->loadPageHeader();
            if ($this->checkLoginandAccess(2)) {
                if ($action == "userList") {
                    $users = array();
                    $users = $this->getAllUsers($action);
                } else if ($action == "editUser") {
                    $user = $data;
                }
                include('content/adminContent.php');
            }
            $this->loadFooter();
        }

        public function loadStaffList()
        {
            $this->loadPageHeader();
            $sideNav = $this->getNavController()->loadSideNavigation(2);
            $adminSection = $this->getNavController()->loadPageAdmin("profile",null);
            $result = $this->getDb()->query("SELECT * FROM profile");
            if($result)
            {
                $users = array();
                while($data = $result->fetch())
                {
                    $user = new Profile($this->getDb(),$data['username']);
                    if($user->getProfile())
                    {
                        $users[] = $user;
                    }
                }
                include('content/staffList.php');
            }
            $this->loadFooter();
        }

        public function loadProjectPage($id)
        {
            $project = new Project($this->getDb(), $id);
            if ($project->getProject()) {
                $this->loadPageHeader();
                $section = new Section($this->getDb(), 3);
                $sideNav = $this->getNavController()->loadSideNavigation($section->getSectionId());
                $adminSection = $this->getNavController()->loadPageAdmin("project", $id);
                $admin = false;
                if (isset($_SESSION['username'])) {
                    $result = $this->getDb()->query("SELECT * FROM project_collaborator WHERE username = '" . $_SESSION['username'] . "' AND projectId = '$id'");
                    if ($data = $result->fetch()) {
                        if ($data['admin'] == 1) {
                            $admin = true;
                        }
                    }
                }

                $publications = count($project->findPublications());

                $item_per_page = 3;

                $pages = ceil($publications/$item_per_page);
                $pagination = '';
                if($pages > 0)
                {
                    $pagination .= '<ul style="text-align:center;" class="pagination pagination-sm">';
                    $pagination .= "<li id='pagination-li-previous' class='disabled'><a href='#'>&laquo;</a></li>";
                    for($i = 1; $i<=$pages; $i++)
                    {
                        $active = "";
                        if($i == 1)
                        {
                            $active = " active";
                        }
                        $pagination .= "<li id='".$i."-pagination-li' class='pagination-li".$active."'><a href='#' class='paginate_click' id='".$i."-page'>".$i."</a></li>";
                    }
                    $pagination .= "<li id='pagination-li-next'><a href='#'>&raquo;</a></li>";
                    $pagination .= '</ul>';
                }

                include('content/projectView.php');
                $this->loadFooter();
            } else {
                $this->pageNotFound();
            }
        }

        public function loadEditPage($id)
        {
            $page = new Page($this->getDb(), $id);
            if ($page->getPageDetails()) {
                $this->loadPageHeader();
                if ($this->checkLoginandAccess(2)) {
                    $sections = $this->getAllSections($id);
                    include("forms/editPage.php");
                }
                $this->loadFooter();
            } else {
                $this->pageNotFound();
            }
        }

        public function loadRandomUsers()
        {
            $result = $this->getDb()->query("SELECT * FROM profile ORDER BY RAND() LIMIT 9;");
            if($result)
            {
                $users = array();
                while($data = $result->fetch())
                {
                    $user = new Profile($this->getDb(),$data['username']);
                    if($user->getProfile())
                    {
                        $users[] = $user;
                    }
                }
                return $users;
            }
        }

        public function loadLatestPublications()
        {
            $result = $this->getDb()->query("SELECT * FROM publication ORDER BY year DESC ,name ASC LIMIT 3;");
            if($result)
            {
                $publications = array();
                while($data = $result->fetch())
                {
                    $publication = new Publication($this->getDb(),$data['publicationId']);
                    if($publication->getPublication())
                    {
                        $publications[] = $publication;
                    }
                }
                return $publications;
            }
        }

        public function loadLatestNews()
        {
            $result = $this->getDb()->query("SELECT * FROM news ORDER BY createdAt DESC LIMIT 3;");
            if($result)
            {
                $articles = array();
                while($data = $result->fetch())
                {
                    $article = new News($this->getDb(),$data['newsId']);
                    if($article->getNews())
                    {
                        $articles[] = $article;
                    }
                }
                return $articles;
            }
        }

        public function loadRandomProjects()
        {
            $result = $this->getDb()->query("SELECT * FROM project ORDER BY RAND() LIMIT 3");
            if($result)
            {
                $projects = array();
                while($data = $result->fetch())
                {
                    $project = new Project($this->getDb(),$data['projectId']);
                    if($project->getProject())
                    {
                        $projects[] = $project;
                    }
                }
                return $projects;
            }
        }

        public function loadEditProject($id)
        {
            $project = new Project($this->getDb(), $id);
            if ($project->getProject()) {
                $this->loadPageHeader();
                $result = "SELECT * FROM project_collaborator WHERE username = '" . $_SESSION['username'] . "' AND admin = '1'";
                if ($this->checkLoginAndAccess(1) || $data = $result->fetch()) {
                    $sections = $this->getAllSections($id);
                    include("forms/editProject.php");
                    $this->loadFooter();
                } else {
                    $this->checkLoginandAccess(3); //This will send the user to Access Denied
                }
            }
        }

        public function loadCreateProject()
        {
            $this->loadPageHeader();
            if($this->checkLoginandAccess(1))
            {
                include('forms/editProject.php');
            }
            $this->loadFooter();
        }

        public function editProject($id, $name, $description, $startDate, $endDate, $website, $newlogo)
        {
            $project = new Project($this->getDb(), $id);
            if ($project->getProject()) {
                $name = htmlspecialchars($name, ENT_QUOTES);
                $description = htmlspecialchars($description, ENT_QUOTES);
                $project->setName($name);
                $project->setDescription($description);
                $project->setStartDate($project->normalToSql($startDate));
                $project->setEndDate($project->normalToSql($endDate));
                $project->setWebsite($website);
                if ($newlogo == "yes") {
                    $allowedExts = array("gif", "jpeg", "jpg", "png");
                    $temp = explode(".", $_FILES["project_logo"]["name"]);
                    $extension = end($temp);
                    if (($_FILES["project_photo"]["size"] < 1000000)
                        && in_array($extension, $allowedExts)
                    ) {
                        if ($_FILES["profile_photo"]["error"] > 0) {
                            echo "Return Code: " . $_FILES["project_logo"]["error"] . "<br>";
                        } else {
                            //echo "Upload: " . $_FILES["project_logo"]["name"] . "<br>";
                            //echo "Type: " . $_FILES["project_logo"]["type"] . "<br>";
                            //echo "Size: " . ($_FILES["project_logo"]["size"] / 1024) . " kB<br>";
                            //echo "Temp file: " . $_FILES["project_logo"]["tmp_name"] . "<br>";

                            //echo "images/project/" .$_FILES["project_logo"]["name"];
                            move_uploaded_file($_FILES["project_logo"]["tmp_name"],
                                               "images/project/" . $_FILES["project_logo"]["name"]);

                            $project->setLogo($_FILES["project_logo"]["name"]);
                        }
                    } else {
                        echo "Invalid file";
                    }
                }
                if ($project->updateProject()) {
                    $this->loadProjectPage($project->getId());
                } else {
                    $error = "The Project has not been updated on the Database. Please retry again!";
                    $this->loadPageHeader();
                    include("forms/editProject.php");
                    $this->loadPageFooter();
                }
            } else {
                $this->pageNotFound();
            }
        }

        public function createNewPage($title, $section, $content, $module, $restricted, $homepage)
        {
            $title = htmlspecialchars($title, ENT_QUOTES);
            $content = htmlspecialchars($content, ENT_QUOTES);
            $page = new Page($this->getDb(), 0);
            $page->setTitle($title);
            $page->setSection(new SectionInfo($this->getDb(), $section));
            $page->getSection()->getHighestNavOrder();
            $page->setAuthor(new Profile($this->getDb(), $_SESSION['username']));
            $page->setRestricted($restricted);
            $page->setContent($content);
            $page->setModule($module);
            if($homepage)
            {
                if($page->makeThisHomepage())
                {
                    $page->setSectionHomepage(true);
                }
            }
            if ($page->createPage()) {
                $this->redirect("?mode=content&id=" . $page->getPageId());
            } else {
                echo "<div class='alert alert-danger'><h3>Oh No!</h3>Looks like there was a problem...</div>";
            }
        }

        public function editPage($pageId, $title, $section, $content, $module, $restricted, $homepage)
        {
            $page = new Page($this->getDb(), $pageId);
            if ($page->getPageDetails()) {
                $title = htmlspecialchars($title, ENT_QUOTES);
                $content = htmlspecialchars($content, ENT_QUOTES);
                $page->setTitle($title);
                $page->setSection(new SectionInfo($this->getDb(), $section));
                $page->setAuthor(new Profile($this->getDb(), $_SESSION['username']));
                $page->setRestricted($restricted);
                $page->setContent($content);
                $page->setModule($module);
                if($homepage)
                {
                    if($page->makeThisHomepage())
                    {
                        $page->setSectionHomepage(true);
                    }
                    else
                    {
                        echo "This didn't work";
                        exit();
                    }
                }
                if ($page->updatePage()) {
                    $this->redirect("?mode=content&id=" . $page->getPageId());
                } else {
                    echo "<div class='alert alert-danger'><h3>Oh No!</h3>Looks like there was a problem...</div>";
                }
            } else {
                $this->pageNotFound();
            }
        }

        public function createPublication($title, $publishedIn, $publisher, $abstract, $year, $link)
        {
            $publication = new Publication($this->getDb(), NULL);
            $publication->setName(htmlentities($title,ENT_QUOTES));
            $publication->setAbstract(htmlentities($abstract,ENT_QUOTES));
            $publication->setPublishedIn(htmlentities($publishedIn,ENT_QUOTES));
            $publication->setPublisher(htmlentities($publisher,ENT_QUOTES));
            $publication->setAbstract(htmlentities($abstract,ENT_QUOTES));
            $publication->setYear($year);
            $publication->setLink($link);
            if($publication->createPublication())
            {
                if($publication->addIlabAuthor($_SESSION['username']))
                {
                    $this->loadPublication($publication->getId());
                }
                else
                {
                    $this->loadUpdateStatus("<div class='alert alert-danger'><h3>Oh Dear! The Publication was not created</h3></div>");
                }
            }
            else
            {
                $this->loadUpdateStatus("<div class='alert alert-danger'><h3>Oh Dear! The Publication was not created</h3></div>");
            }
        }

        public function loadPublication($id)
        {
            $publication = new Publication($this->getDb(),$id);
            if($publication->getPublication())
            {
                $this->loadPageHeader();
                $sideNav = $this->getNavController()->loadSideNavigation(4);
                $adminSection = $this->getNavController()->loadPageAdmin("publication",$id);
                $projects = $publication->getProjects();
                include("content/viewPublication.php");
                $this->loadFooter();
            }
            else
            {
                $this->pageNotFound();
            }
        }

        public function loadPublicationList()
        {
            //Page Set up
            if(isset($_GET['username']))
            {
                $user = new Profile($this->getDb(),$_GET['username']);
                $user->getProfile();
                $title = "Publications by ".$user->getRealName();
            }
            else
            {
                $title = "Publications";
            }
            $sideNav = $this->getNavController()->loadSideNavigation(4);
            $adminSection = $this->getNavController()->loadPageAdmin("publication",NULL);

            //Pagination Set up
            $item_per_page = 10;

            $results = $this->getDb()->query("SELECT COUNT(*) AS count FROM ".$this->getDb()->getPrefix()."publication");
            $get_total_rows = $results->fetch(); //total records

            $projects = $this->getAllProjects("all");

            //break total records into pages
            $pages = ceil($get_total_rows['count']/$item_per_page);
            //create pagination
            $pagination = '';
            if($pages >= 1)
            {
                $pagination .= '<ul style="text-align:center;" class="pagination pagination-lg">';
                $pagination .= "<li id='pagination-li-previous' class='disabled'><a href='#'>&laquo;</a></li>";
                for($i = 1; $i<=$pages; $i++)
                {
                    $pagination .= "<li id='".$i."-pagination-li' class='pagination-li'><a href='#' class='paginate_click' id='".$i."-page'>".$i."</a></li>";
                }

                if($pages != 1)
                {
                    $pagination .= "<li id='pagination-li-next'><a href='#'>&raquo;</a></li>";
                }
                else
                {
                    $pagination .= "<li id='pagination-li-next' class='disabled'><a href='#'>&raquo;</a></li>";
                }
                $pagination .= '</ul>';
            }

            $this->loadPageHeader();
            include('content/publicationList.php');
            $this->loadFooter();

        }

        public function createUser($username, $realname, $email, $access, $password, $hidden)
        {
            $user = new User($this->getDb(), $username);
            $user->getProfile()->setRealName($realname);
            $user->getProfile()->setEmail($email);
            $user->setAccessLevel($access);
            $user->setPassword($password);
            $user->setHidden($hidden);
            if ($user->createUser()) {
                $this->loadUpdateStatus("<div class='alert alert-success'><h3>$username has been created successfully</h3></div><a class='btn btn-primary' href='?mode=admin&action=userList'>Go to User List</a>");
            } else {
                $this->loadUpdateStatus("<div class='alert alert-danger'><h3>Oh Dear! The user wasn't created!</h3></div>");
            }
        }

        public function editSponsor($sponsorId, $name, $website, $new_photo, $file, $project)
        {
            $sponsor = new Sponsor($this->getDb(), $sponsorId);
            if ($sponsor->getSponsor()) {
                $sponsor->setName($name);
                $sponsor->setWebsite($website);
                if ($new_photo == "yes") {
                    $this->upload($file, "images/sponsor/", $file['name']);
                    $sponsor->setLogo($file['name']);
                }
                if ($sponsor->updateSponsor()) {
                    $success = "Sponsor successfully Updated";
                } else {
                    $error = "Sorry! We couldn't update the Sponsor!";
                }
                $this->loadSponsorsList($project);
            } else {
                $this->loadSponsorsList($project);
            }
        }

        public function editUser($admin, $username, $realname, $email, $access, $newpassword, $password, $hidden, $role, $website, $bio, $pureId, $twitter, $scholar, $linkedin, $newphoto, $photolink)
        {
            if ($newphoto == "yes") {
                $allowedExts = array("gif", "jpeg", "jpg", "png");
                $temp = explode(".", $_FILES["profile_photo"]["name"]);
                $extension = end($temp);
                if (($_FILES["profile_photo"]["size"] < 1000000)
                    && in_array($extension, $allowedExts)
                ) {
                    if ($_FILES["profile_photo"]["error"] > 0) {
                        echo "Return Code: " . $_FILES["profile_photo"]["error"] . "<br>";
                    } else {
                        //echo "Upload: " . $_FILES["profile_photo"]["name"] . "<br>";
                        //echo "Type: " . $_FILES["profile_photo"]["type"] . "<br>";
                        //echo "Size: " . ($_FILES["profile_photo"]["size"] / 1024) . " kB<br>";
                        //echo "Temp file: " . $_FILES["profile_photo"]["tmp_name"] . "<br>";


                        move_uploaded_file($_FILES["profile_photo"]["tmp_name"],
                                           "images/profile/" . $username . "." . $extension);
                        $photolink = $username . "." . $extension;
                    }
                } else {
                    echo "Invalid file";
                }
            }
            $user = new User($this->getDb(), $username);
            $user->getUser();
            $user->getProfile()->getProfile();

            $user->getProfile()->setRealName($realname);
            $user->getProfile()->setEmail($email);
            $user->getProfile()->setRole($role);
            $user->getProfile()->setWebsite($website);
            $user->getProfile()->setBio(htmlspecialchars($bio, ENT_QUOTES));
            $user->getProfile()->setTwitter($twitter);
            $user->getProfile()->setScholar($scholar);
            $user->getProfile()->setLinkedIn($linkedin);

            if ($newphoto == "yes") {
                $user->getProfile()->setPhoto($photolink);
            }

            if ($admin == 1) {
                $user->setAccessLevel($access);
                $user->setHidden($hidden);
            }

            if ($newpassword == "yes") {
                $user->updatePassword($password);
            }

            if ($user->updateUser()) {
                if ($admin == 1) {
                    $this->loadAdminPage("userList");
                } else {
                    $this->loadProfile($user->getUserName());
                }
            }
        }

        public function loadNews($id)
        {
            $news = new News($this->getDb(),$id);
            if($news->getNews())
            {
                $adminSection = $this->getNavController()->loadPageAdmin("news",$id);
                $sideNav = $this->getNavController()->loadSideNavigation(6);
                $date = date("D d F Y",strtotime($news->getCreated()));
                $this->loadPageHeader();
                include("content/viewNews.php");
                $this->loadFooter();
            }
        }

        public function loadNewsList()
        {
            //Page Set up
            $title = "News Archive";
            $sideNav = $this->getNavController()->loadSideNavigation(6);
            $adminSection = $this->getNavController()->loadPageAdmin("news",NULL);

            //Pagination Set up
            $item_per_page = 10;

            $results = $this->getDb()->query("SELECT COUNT(*) AS count FROM ".$this->getDb()->getPrefix()."news");
            $get_total_rows = $results->fetch(); //total records

            //break total records into pages
            $pages = ceil($get_total_rows['count']/$item_per_page);
            //create pagination
            $pagination = '';
            if($pages >= 1)
            {
                $pagination .= '<ul style="text-align:center;" class="pagination pagination-lg">';
                $pagination .= "<li id='pagination-li-previous' class='disabled'><a href='#'>&laquo;</a></li>";
                for($i = 1; $i<=$pages; $i++)
                {
                    $pagination .= "<li id='".$i."-pagination-li' class='pagination-li'><a href='#' class='paginate_click' id='".$i."-page'>".$i."</a></li>";
                }

                if($pages != 1)
                {
                    $pagination .= "<li id='pagination-li-next'><a href='#'>&raquo;</a></li>";
                }
                else
                {
                    $pagination .= "<li id='pagination-li-next' class='disabled'><a href='#'>&raquo;</a></li>";
                }
                $pagination .= '</ul>';
            }

            $this->loadPageHeader();
            include('content/newsList.php');
            $this->loadFooter();
        }

        public function redirect($url)
        {
            ?>
            <script>
                window.location = "index.php<?php echo $url; ?>"
            </script>
        <?php
        }

        public function loadCreateNews()
        {
            $this->loadPageHeader();
            if($this->checkLoginandAccess(0))
            {
                include("forms/editNews.php");
            }
            $this->loadFooter();
        }

        public function loadEditNews($id)
        {
            $this->loadPageHeader();
            $news = new News($this->getDb(),$id);
            if($news->getNews())
            {
                if($this->checkLoginandAccess(0) || $news->getAuthor() == $_SESSION['username'])
                {
                    include("forms/editNews.php");
                }
            }
            else
            {
                $this->loadUpdateStatus("ERROR");
            }
            $this->loadFooter();
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
            $adminSection = $this->getNavController()->loadPageAdmin($_GET['mode'], NULL);
            $projects = $this->getAllProjects($past);
            include('content/projectList.php');
            $this->loadFooter();
        }


        public function loadSponsorsList($projectId)
        {
            $sponsors = array();
            $project = new Project ($this->getDb(), $projectId);
            if ($project->getProject()) {
                $sponsors = $project->findPartners();
                $fullSponsorList = $this->getAllSponsors();
                if ($_SESSION['access_level'] > 0 || $project->checkIfAdmin($_SESSION['username'])) {
                    $this->loadPageHeader();
                    include("content/manageProjectSponsors.php");
                    $this->loadFooter();
                } else {
                    $this->loadAccessDenied();
                }
            } else {
                $this->pageNotFound();
            }
        }

        public function loadCollaboratorsList($projectId)
        {
            $collaborators = array();
            $project = new Project($this->getDb(), $projectId);
            if ($project->getProject()) {
                $collaborators = $project->findContributors();
                $nonContributors = $project->findNonContributors();
                if ($_SESSION['access_level'] > 0 || $project->checkIfAdmin($_SESSION['username'])) {
                    $this->loadPageHeader();
                    include("content/manageCollaborators.php");
                    $this->loadFooter();
                } else {
                    $this->loadAccessDenied();
                }
            }
        }

        public function getAllSponsors()
        {
            $sponsors = array();
            $result = $this->getDb()->query("SELECT * FROM sponsor");
            if ($result) {
                while ($data = $result->fetch()) {
                    $sponsor = new Sponsor($this->getDb(), $data['sponsorId']);
                    if ($sponsor->getSponsor()) {
                        $sponsors[] = $sponsor;
                    }
                }
            }
            return $sponsors;
        }

        public function loadContentPage($id)
        {
            $this->loadPageHeader();
            $page = new Page($this->getDb(), $id);
            if ($page->getPageDetails()) {
                if (!$page->getRestricted() || ($page->getRestricted() && isset($_SESSION['login']))) {
                    $section = $page->getSection()->getSectionId();
                    $sideNav = $this->getNavController()->loadSideNavigation($section);
                    $adminSection = $this->getNavController()->loadPageAdmin($_GET['mode'], $id);
                    include('content/content.php');
                } else {
                    $this->loadLoginRequired();
                }
            } else {
                $this->contentNotFound();
            }
            $this->loadFooter();
        }

        public function loadCreatePage()
        {
            $this->loadPageHeader();
            if ($this->checkLoginandAccess(2)) {
                $sections = $this->getAllSections(0);
                include("forms/editPage.php");
            }
            $this->loadFooter();
        }

        public function loadCreateUser()
        {
            $this->loadPageHeader();
            if ($this->checkLoginandAccess(2)) {
                include("forms/addUser.php");
            }
            $this->loadFooter();
        }

        public function loadCreatePublication()
        {
            $this->loadPageHeader();
            if ($this->checkLoginandAccess(0)) {
                include("forms/createPublication.php");
            }
            $this->loadFooter();
        }

        public function loadEditSponsor($id)
        {
            $this->loadPageHeader();
            if ($this->checkLoginandAccess(1)) {
                $sponsor = new Sponsor($this->getDb(), $id);
                if ($sponsor->getSponsor()) {
                    include("forms/editSponsor.php");
                } else {
                    $this->contentNotFound();
                }
            }
            $this->loadFooter();
        }

        public function loadEditPublication($id)
        {
            $this->loadPageHeader();
            $publication = new Publication($this->getDb(),$id);
            if($publication->getPublication())
            {
                include("forms/editPublication.php");
            }
            else
            {
                $this->contentNotFound();
            }
            $this->loadFooter();
        }

        public function loadProfile($user)
        {
            $this->loadPageHeader();
            $profile = new Profile($this->getDb(),$user);
            if($profile->getProfile())
            {
                $sideNav = $this->getNavController()->loadSideNavigation(2);
                $adminSection = $this->getNavController()->loadPageAdmin("profile",$profile->getUsername());

                $publications = array();
                $projects = $profile->getProjects();

                $query = "SELECT A.publicationId FROM publication P, publication_author A WHERE A.username = '".$profile->getUsername()."' AND P.publicationId = A.publicationId ORDER BY P.year DESC, P.name ASC";
                $result = $this->getDb()->query($query);
                if($result)
                {
                    $publicationCount = $result->rowCount();
                    $count = 0;
                    while($data = $result->fetch())
                    {
                        $publication = new Publication($this->getDb(),$data['publicationId']);
                        if($publication->getPublication())
                        {
                            $publications[] = $publication;
                            $count++;
                        }
                        if($count >= 3)
                        {
                            break;
                        }
                    }
                }

                $pub_output = array();
                foreach($publications as $publication)
                {
                    $output = "<a href='?mode=publication&id=".$publication->getId()."'><div class='well'>";

                    $authorResults = $this->getDb()->query("SELECT * FROM publication_author WHERE publicationId = '".$publication->getId()."'");
                    $first = true;
                    while($author = $authorResults->fetch())
                    {
                        if(!$first)
                        {
                            $output .= ", ";
                        }
                        $first = false;
                        if($author['username'] == "null" || strlen($author['username']) == 0)
                        {
                            $output .= $author['nameOfAuthor']." ";
                        }
                        else
                        {
                            $RealNameResult = $this->getDb()->query("SELECT real_name FROM profile WHERE username = '".$author['username']."'");
                            if($RealNameResult)
                            {
                                $realname = $RealNameResult->fetch();
                                $output .= $realname['real_name']." ";
                            }
                        }
                    }
                    $title = "<b>".$publication->getName()."</b>";
                    $year = "<em>(".$publication->getYear().")</em>";
                    if(strlen($publication->getPublishedIn()) > 0)
                    {
                        $publishedIn = $publication->getPublishedIn();
                    }
                    $output .= $year." ".$title.", <em>".$publishedIn."</em>, ".$publication->getPublisher()."</div></a>";
                    $pub_output[] = $output;
                }


                include("content/viewProfile.php");
            }
            else
            {
                $this->loadUpdateStatus("<div class='alert alert-danger'>Couldn't find Profile</div>");
            }
            $this->loadFooter();
        }

        public function loadEditUser($mode, $username)
        {
            if ($mode == "admin") {
                $user = new User($this->getDb(), $username);
                $user->getUser();
                $user->getProfile()->getProfile();
                $this->loadAdminPage("editUser", $user);
            } else {
                $user = new User($this->getDb(), $username);
                $this->loadPageHeader();
                include("forms/editUser.php");
                $this->loadFooter();
            }
        }

        public function getAllSections($id)
        {
            $result = $this->getDb()->query("SELECT * FROM section");
            $page = $this->getDb()->query("SELECT section FROM page WHERE page_id = '".$id."'");
            $pageData = $page->fetch();
            $sections = "";
            if ($result) {
                while ($data = $result->fetch()) {
                    $sections .= "<option value='" . $data['section_id'] . "'";
                    if ($data['section_id'] == $pageData['section']) {
                        $sections .= "selected";
                    }
                    $sections .= ">" . $data['name'] . "</option>";
                }
            }
            return $sections;
        }

        public function getAllProjects($past)
        {
            if ($past == 1) {
                $where = "WHERE endDate < CURDATE()";
            } else if($past == 0) {
                $where = "WHERE endDate > CURDATE()";
            } else {
                $where = "";
            }
            $result = $this->getDb()->query("SELECT * FROM project " . $where);
            $projects = array();
            if ($result) {
                while ($data = $result->fetch()) {
                    $project = new Project($this->getDb(), $data['projectId']);
                    $project->getProject();
                    $projects[] = $project;
                }
            }
            return $projects;
        }

        public function checkLoginandAccess($levelRequired)
        {
            if (isset($_SESSION['login'])) {
                $user = new User($this->getDb(), $_SESSION['username']);
                $user->getUser();
                if ($user->getAccessLevel() >= $levelRequired) {
                    return true;
                } else {
                    $this->loadAccessDenied();
                }
            } else {
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
            while ($data = $result->fetch()) {
                $user = new User($this->getDb(), $data['username']);
                $user->getUser();
                $user->getProfile()->getProfile();
                $users[] = $user;
            }
            return $users;
        }

        public function addSponsorLink($sponsorId, $projectId, $type)
        {
            $sponsor = new Sponsor($this->getDb(), $sponsorId);
            if ($sponsor->getSponsor()) {
                if ($sponsor->addLink($projectId, $type)) {
                    $success = $sponsor->getName() . "added to project as a " . $type;
                } else {
                    $error = "Link couldn't be added";
                }
            } else {
                $error = "Couldn't find Sponsor in Database";
            }
            $this->loadSponsorsList($projectId);
        }

        public function removeSponsorLink($sponsorId, $projectId)
        {
            $sponsor = new Sponsor($this->getDb(), $sponsorId);
            if ($sponsor->getSponsor()) {
                if ($sponsor->removeLink($projectId)) {
                    $success = $sponsor->getName() . "has been removed from this project!";
                }
            } else {
                $error = "Sponsor Link wasn't removed!";
            }
            $this->loadSponsorsList($projectId);
        }

        public function addContributorToProject($projectId, $username, $admin, $hidden)
        {
            $project = new Project($this->getDb(), $projectId);
            if ($project->getProject()) {
                if ($project->addCollaborator($username, $admin, $hidden)) {
                    $this->loadCollaboratorsList($projectId);
                } else {
                    $this->pageNotFound();
                }
            } else {
                print("Lalal");
                $this->pageNotFound();
            }
        }

        public function removeContributorFromProject($projectId, $username)
        {
            $project = new Project($this->getDb(), $projectId);
            if ($project->getProject()) {
                if ($project->removeCollaborator($username)) {
                    $this->loadCollaboratorsList($projectId);
                } else {
                    $this->pageNotFound();
                }
            } else {
                $this->pageNotFound();
            }
        }

        public function loadAuthorList($pub_id)
        {
            $publication = new Publication($this->getDb(),$pub_id);
            if($publication->getPublication())
            {
                $authors = $publication->getAuthors();
                $ilabUsers = $publication->getNonAuthors();
                if($this->checkLoginandAccess(1) || $publication->checkIfAuthor($_SESSION['username']))
                {
                    $this->loadPageHeader();
                    include('content/manageAuthors.php');
                    $this->loadFooter();
                }
                else
                {
                    $this->loadAccessDenied();
                }
            }
        }

        public function loadPubProjectList($pub_id)
        {
            $publication = new Publication($this->getDb(),$pub_id);
            if($publication->getPublication())
            {
                $projects = $publication->getProjects();
                $nonProjects = $publication->getNonProjects();
                if($this->checkLoginandAccess(1) || $publication->checkIfAuthor($_SESSION['username']))
                {
                    $this->loadPageHeader();
                    include('content/managePublicationProjects.php');
                    $this->loadFooter();
                }
                else
                {
                    $this->loadAccessDenied();
                }
            }
        }

        public function upload($file, $directory, $fileName)
        {
            $allowedExts = array("gif", "jpeg", "jpg", "png", "pdf");
            $temp = explode(".", $file["name"]);
            $extension = end($temp);
            if (($file["size"] < 100000000) && in_array($extension, $allowedExts)) {
                if ($file["error"] > 0) {
                    echo "Return Code: " . $file["error"] . "<br>";
                } else {
                    //echo "Upload: " . $_FILES["profile_photo"]["name"] . "<br>";
                    //echo "Type: " . $_FILES["profile_photo"]["type"] . "<br>";
                    //echo "Size: " . ($_FILES["profile_photo"]["size"] / 1024) . " kB<br>";
                    //echo "Temp file: " . $_FILES["profile_photo"]["tmp_name"] . "<br>";
                    move_uploaded_file($file["tmp_name"], $directory.$fileName);
                    return($directory.$fileName);
                }
            } else {
                echo "Invalid file ".$file["size"];
            }
        }

        public function reorder($pageId,$direction)
        {
            $page = new Page($this->getDb(),$pageId);
            if($page->getPageDetails())
            {
                $currentPageOrder = $page->getNavOrder();
                if(($direction == -1 && $currentPageOrder == 1) || ($direction == 1 && $currentPageOrder == $page->getSection()->getHighestNavOrder()))
                {
                    $page->redirectToPage();
                }
                else
                {
                    if(strcmp($direction,"up") == 0)
                    {
                        $newPageOrder = $currentPageOrder - 1;
                    }
                    else
                    {
                        $newPageOrder = $currentPageOrder + 1;
                    }
                    $result = $this->getDb()->query("SELECT page_id FROM page WHERE navOrder = '".$newPageOrder."' AND page_id <> '".$page->getPageId()."' AND section = '".$page->getSection()->getSectionId()."'");
                    if($result)
                    {
                        $data = $result->fetch();
                        $switchPage = new Page($this->getDb(),$data['page_id']);
                        if($switchPage->getPageDetails())
                        {
                            $tmp = $page->getNavOrder();
                            $page->setNavOrder($switchPage->getNavOrder());
                            $switchPage->setNavOrder($tmp);



                            if($page->updatePage() && $switchPage->updatePage())
                            {
                                $page->redirectToPage();
                            }
                        }
                        else
                        {
                            $page->setNavOrder($newPageOrder);
                            if($page->updatePage())
                            {
                                $page->redirectToPage();
                            }
                        }
                    }
                    else
                    {
                        $page->redirectToPage();
                    }
                }
            }
            else
            {
                $this->loadUpdateStatus("<div class='alert alert-danger'><b>Page Not Found</b><br/><p>Page could not be found in order to Reorder</p></div>");
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