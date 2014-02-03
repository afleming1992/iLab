<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 02/02/14
 * Time: 13:28
 */

class SectionInfo
{
    //Used in Pages for storing information about the Section it occupies
    private $db;

    private $sectionId;
    private $name;
    private $restricted;

    public function __construct($db,$sectionId)
    {
       $this->sectionId = $sectionId;
       $this->db = $db;
    }

    public function getDetails()
    {
        $result = $this->db->query("SELECT * FROM section WHERE section_id = '".$this->getSectionId()."'");
        $rowCount = $result->rowCount();
        if($rowCount > 0)
        {
            $data = $result->fetch();
            $this->setName($data['name']);
            $this->setRestricted($data['restricted']);
            return true;
        }
        else
        {
            return false;
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
     * @param mixed $homepage
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;
    }

    /**
     * @return mixed
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $restricted
     */
    public function setRestricted($restricted)
    {
        $this->restricted = $restricted;
    }

    /**
     * @return mixed
     */
    public function getRestricted()
    {
        return $this->restricted;
    }

    /**
     * @param mixed $sectionId
     */
    public function setSectionId($sectionId)
    {
        $this->sectionId = $sectionId;
    }

    /**
     * @return mixed
     */
    public function getSectionId()
    {
        return $this->sectionId;
    }


} 