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
                    $section->getPages();
                    if($section->getHomepage() != null)
                    {
                        $mainNav .= "<li><a href='?mode=content&id=".$section->getHomepage()->getPageId()."'>".$section->getName()."</a></li>";
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
                $sideNav .= "<a href='?mode=content&id=".$section->getHomepage()->getPageId()."'";
                $sideNav .= ">".$section->getHomepage()->getTitle()."</a></li>";
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
                $sideNav .= $activeNav."<a href='?mode=content&id=".$pages[$i]->getPageId()."'>".$pages[$i]->getTitle()."</a></li>";
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