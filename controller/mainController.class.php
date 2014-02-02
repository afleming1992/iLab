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

    public function _construct($db)
    {
        $this->setDb($db);
    }

    public function loadHomePage()
    {
        $this->loadPageHeader();
        include('content/homepage.php');
        $this->loadFooter();
    }

    public function loadPageHeader()
    {
        include('content/header.php');
    }

    public function loadFooter()
    {
        include('content/footer.php');
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