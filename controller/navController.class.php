<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 02/02/14
 * Time: 16:37
 */

class navController {

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function loadMainNavigation()
    {
        $mainNav = "";
        $result = $this->db->query("SELECT section_id FROM section ORDER BY navOrder ASC");
        if($result)
        {
            $rowCount = $result->rowCount($result);
            for($i = 0;$i < $rowCount;$i++)
            {
                $row = $result->fetch();
                $section = new Section($this->getDb(),$row['section_id']);
                if($section->getDetails())
                {
                    if(!$section->getRestricted() || ($section->getRestricted() && isset($_SESSION['access_level'])))
                    {
                        $section->findPages();
                        if($section->getHomepage() != null)
                        {
                            $mainNav .= "<li><a href='#' class='dropdown-toggle' data-toggle='dropdown'>".$section->getName()." <b class='caret'></b></a>";
                            $mainNav .= "<ul class='dropdown-menu'>";
                            if(strlen($section->getHomepage()->getNavOveride()) > 0)
                            {
                                $mainNav .= "<li><a href='".$section->getHomepage()->getNavOveride()."'>".$section->getHomepage()->getTitle()."</a>";
                            }
                            else
                            {
                                $mainNav .= "<li><a href='?mode=content&id=".$section->getHomepage()->getPageId()."'>".$section->getHomepage()->getTitle()."</a>";
                            }
                            $pages = $section->getPages();
                            foreach($pages as $page)
                            {
                                if(strlen($page->getNavOveride()) > 0)
                                {
                                    $mainNav .= "<li><a href='".$page->getNavOveride()."'>".$page->getTitle()."</a></li>";
                                }
                                else
                                {
                                    $mainNav .= "<li><a href='?mode=content&id=".$page->getPageId()."'>".$page->getTitle()."</a></li>";
                                }
                            }
                            $mainNav .= "</ul></li>";
                        }
                    }
                }
            }
            return $mainNav;
        }
    }

    public function loadSideNavigation($section)
    {
        $sideNav = "<ul class='nav nav-pills nav-stacked'>";
        $section = new Section($this->getDb(),$section);
        if($section->getDetails())
        {
            //Put the Homepage of Section at the Top;
            if($section->getHomePage()->getPageDetails())
            {
                if($_GET['id'] == $section->getHomepage()->getPageId())
                {
                    $sideNav .= "<li class='active'>";
                }
                else
                {
                    $sideNav .= "<li>";
                }

                if(strlen($section->getHomePage()->getNavOveride()) > 0)
                {
                    $sideNav .= "<a href='".$section->getHomepage()->getNavOveride()."'";
                    $sideNav .= ">".$section->getHomepage()->getTitle()."</a></li>";
                }
                else
                {
                    $sideNav .= "<a href='?mode=content&id=".$section->getHomepage()->getPageId()."'";
                    $sideNav .= ">".$section->getHomepage()->getTitle()."</a></li>";
                }
            }
            else
            {
                $sideNav .= "<li>Can't Find Homepage</li>";
            }

            //All other Pages as and when
            $section->findPages();
            $pages = $section->getPages();
            $pageCount = count($pages);
            for($i = 0;$i < $pageCount;$i++)
            {
                if($pages[$i]->getPageId() == $_GET['id'])
                {
                    $activeNav = "<li class='active'>";
                }
                else
                {
                    $activeNav = "<li>";
                }

                if(strlen($pages[$i]->getNavOveride()) > 0)
                {
                    $sideNav .= $activeNav."<a href='".$pages[$i]->getNavOveride()."'>".$pages[$i]->getTitle()."</a></li>";
                }
                else
                {
                    $sideNav .= $activeNav."<a href='?mode=content&id=".$pages[$i]->getPageId()."'>".$pages[$i]->getTitle()."</a></li>";
                }
            }
            $sideNav .= "</ul>";
            return $sideNav;
        }
        else
        {
            print("ERROR: Couldn't get Section Details");
            exit();
        }
        return $sideNav;
    }

    public function loadPageAdmin($mode,$id)
    {
        $adminNav = "<ul class='nav nav-pills nav-stacked'>";
        if($mode == "content")
        {
            $adminNav .= "<li><a href='?mode=create&type=page'><span class='glyphicon glyphicon-plus'></span> Create New Page</a></li><li><a href='?mode=edit&type=page&id=".$id."'><span class='glyphicon glyphicon-pencil'></span> Edit This Page</a></li>";
        }
        else if($mode == "project")
        {
            if(strlen($id) > 0)
            {
                $adminNav .= "<li><a href='?mode=edit&type=project&id=".$id."'><span class='glyphicon glyphicon-pencil'></span> Edit This Project</a></li>";
                $adminNav .= "<li><a href='?mode=manage&type=sponsor&id=".$id."'>Manage Sponsor/Partner</a></li>";
                $adminNav .= "<li><a href='?mode=manage&type=collaborator&id='".$id."'>Manage Collaborators</a></li>";
            }
            else
            {
                $adminNav .= "<li><a href='?mode=create&type=project'><span class='glyphicon glyphicon-plus'></span> Create New Project</a></li>";
            }
        }
        $adminNav .= "</ul>";
        return $adminNav;
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


} 