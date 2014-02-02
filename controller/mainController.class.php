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

    public function __construct($db)
    {
        $this->setDb($db);
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
            $sideNav = $this->loadSideNavigation();
            include('content/content.php');
        }
        else
        {
            $this->pageNotFound();
        }
        $this->loadFooter();
    }

    //Part Loaders

    public function loadPageHeader()
    {
        include('content/header.php');
    }

    public function pageNotFound()
    {
        include('content/404.php');
    }

    public function loadSideNavigation()
    {
        $sideNav = "<ul class='nav nav-pills nav-stacked'>";
        $sideNav .= "<li><a href='#'>Testing</a></li>";
        $sideNav .= "</ul>";
        return $sideNav;
    }

    public function loadFooter()
    {
        include('content/footer.php');
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


} 