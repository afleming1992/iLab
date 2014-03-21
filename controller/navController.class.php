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
            /*
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
            }*/

            //All other Pages as and when
            $section->findPages();
            $pages = $section->getPages();
            $pageCount = count($pages);
            for($i = 0;$i < $pageCount;$i++)
            {
                if("?".$_SERVER['QUERY_STRING'] == $pages[$i]->getNavOveride() || $_GET['id'] == $pages[$i]->getPageId())
                {
                    $activeNav = "<li class='active'>";
                }
                else
                {
                    $activeNav = "<li>";
                }

                if(strlen($pages[$i]->getNavOveride()) > 0)
                {
                    $link = $pages[$i]->getNavOveride();
                }
                else
                {
                    $link = "?mode=content&id=".$pages[$i]->getPageId()."'";
                }

                if($_SESSION['access_level'] == 2)
                {
                    $ordering = "<div class='col-md-4' style='padding-left:5px; padding-right:5px;'>";
                    if($i != 0)
                    {
                        $ordering .= "<a href='?mode=reorder&direction=up&id=".$pages[$i]->getPageId()."' class='btn btn-link ordering' href='#'><span class='glyphicon glyphicon-arrow-up'></span></a>";
                    }

                    if(($i + 1) != $pageCount)
                    {
                        $ordering .= "<a href='?mode=reorder&direction=down&id=".$pages[$i]->getPageId()."' class='btn btn-link ordering' href='#'><span class='glyphicon glyphicon-arrow-down'></span></a>";
                    }
                    $ordering .= "</div>";
                }
                else
                {
                    $ordering = "";
                }
                $sideNav .= $activeNav."<a class='col-md-8' href='$link'>".$pages[$i]->getTitle()."</a>".$ordering."</li>";
            }
                $sideNav .= "</ul>";
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
        $beginning = "<ul class='nav nav-pills nav-stacked'>";
        $adminNav = "";
        if($mode == "content")
        {
            $adminNav .= "<li><a href='?mode=create&type=page'><span class='glyphicon glyphicon-plus'></span> Create New Page</a></li><li><a href='?mode=edit&type=page&id=".$id."'><span class='glyphicon glyphicon-pencil'></span> Edit This Page</a></li>";
            $adminNav .= "<li><a href='' data-toggle='modal' data-target='#delete'><span class='glyphicon glyphicon-trash'></span> Delete Page</a></li>";
        }
        else if($mode == "project")
        {
            if(strlen($id) > 0)
            {
                $adminNav .= "<li><a href='?mode=edit&type=project&id=".$id."'><span class='glyphicon glyphicon-pencil'></span> Edit This Project</a></li>";
                $adminNav .= "<li><a href='?mode=manage&type=sponsor&id=".$id."'>Add Partners</a></li>";
                $adminNav .= "<li><a href='?mode=manage&type=collaborator&id=".$id."'>Add People</a></li>";
                $adminNav .= "<li><a data-toggle='modal' data-target='#delete'><span class='glyphicon glyphicon-trash'></span> Delete Project</a></li>";
            }
            else
            {
                $adminNav .= "<li><a href='?mode=create&type=project'><span class='glyphicon glyphicon-plus'></span> Create New Project</a></li>";
            }
        }
        else if($mode == "profile")
        {
            if(isset($_SESSION['access_level']))
            {
                if($_SESSION['access_level'] == 2 && strcmp($_SESSION['username'],$id) != 0)
                {
                    $adminNav .= "<li><a href='?mode=admin&action=editUser&id=".$id."'><span class='glyphicon glyphicon-pencil'></span> Edit Profile</a></li>";
                }
                else
                {
                    if($_SESSION['username'] == $id)
                    {
                        $adminNav .= "<li><a href='?mode=edit&type=user'><span class='glyphicon glyphicon-pencil'></span> Edit Profile</a></li>";
                    }
                }
            }
        }
        else if($mode == "publication")
        {
            if(strlen($id) > 0)
            {
                $adminNav .= "<li><a href='?mode=edit&type=publication&id=".$id."'><span class='glyphicon glyphicon-pencil'></span> Edit Publication</a></li>";
                $adminNav .= "<li><a href='?mode=manage&type=author&id=".$id."'><span class='glyphicon glyphicon-user'></span> Add Authors</a></li>";
                $adminNav .= "<li><a href='?mode=manage&type=pub_project&id=".$id."'><span class='glyphicon glyphicon-folder-open'></span> Link to Projects</a></li>";
                $adminNav .= "<li><a href='' data-toggle='modal' data-target='#stats'><span class='glyphicon glyphicon-stats'></span> View Publication Stats</a></li>";
                $adminNav .= "<li><a href='' data-toggle='modal' data-target='#delete'><span class='glyphicon glyphicon-trash'></span> Delete Publication</a></li>";
            }
            else
            {
                $adminNav .= "<li><a href='?mode=create&type=publication'><span class='glyphicon glyphicon-plus'></span> Create New Publication</a>";
            }
        }
        else if($mode == "news")
        {
            if(strlen($id) > 0)
            {
                $adminNav .= "<li><a href='?mode=edit&type=news&id=".$id."'><span class='glyphicon glyphicon-pencil'></span> Edit Article</a></li>";
                $adminNav .= "<li><a href='' data-toggle='modal' data-target='#delete'><span class='glyphicon glyphicon-trash'></span> Delete Article</a></li>";
            }
            else
            {
                $adminNav .= "<li><a href='?mode=create&type=news'><span class='glyphicon glyphicon-plus'></span> Create News Article</a>";
            }
        }
        $end = "</ul>";
        if(strlen($adminNav) > 0)
        {
            $adminNav = $beginning.$adminNav.$end;
        }
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