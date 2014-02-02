<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 01/02/14
 * Time: 20:57
 */

class section
{
    private $db;

    private $sectionId;
    private $homepage;
    private $name;
    private $restricted;

    public function __construct($db,$sectionId)
    {
        $this->db = $db;
        $this->sectionId = $sectionId;
    }

    public function createSection()
    {
        $result = $this->db->exec("INSERT INTO ".$this->db->getPrefix()."section (homepage_id,name,restricted) VALUES ('".$this->getHomepage()->getPageId()."','".$this->getName()."','".$this->getRestricted()."')");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getDetails()
    {
        $result = $this->db->query("SELECT * FROM ".$this->db->getPrefix()."section WHERE section_id = '".$this->getSectionId()."'");
        if($result)
        {
            $data = $result->fetch();
            $this->setHomepage(new Page($this->db,$data['homepage_id']));
            $this->setName($data['name']);
            $this->setRestricted($data['restricted']);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function updateSection()
    {
        $result = $this->db->exec("UPDATE ".$this->db->getPrefix()."section SET homepage = ".$this->getHomepage()->getPageId().", name = '".$this->getName()."', restricted = '".$this->getRestricted."' WHERE section_id = ".$this->getSectionId());
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function setDb($db)
    {
        $this->db = $db;
    }/**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }/**
     * @param mixed $homepage
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;
    }/**
     * @return mixed
     */
    public function getHomepage()
    {
        return $this->homepage;
    }/**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }/**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }/**
     * @param mixed $restricted
     */
    public function setRestricted($restricted)
    {
        $this->restricted = $restricted;
    }/**
     * @return mixed
     */
    public function getRestricted()
    {
        return $this->restricted;
    }/**
     * @param mixed $sectionId
     */
    public function setSectionId($sectionId)
    {
        $this->sectionId = $sectionId;
    }/**
     * @return mixed
     */
    public function getSectionId()
    {
        return $this->sectionId;
    }


} 