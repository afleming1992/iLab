<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 22/02/14
 * Time: 22:38
 */

class Publication
{
    private $db;

    private $id;
    private $name;
    private $year;
    private $timestamp;
    private $abstract;
    private $uploaded;

    private $authors;
    private $projects;

    public function __construct($db,$id)
    {
        $this->setDb($db);
        $this->setId($id);
        $this->authors = array();
        $this->projects = array();
    }

    public function createPublication()
    {
        $result = $this->getDb()->query("INSERT INTO publication (name,year,abstract,file) VALUES ('".$this->getName()."','".$this->getYear()."','".$this->getAbstract()."','".$this->getFile()."')");
        if($result)
        {
            $this->setId($this->getDb()->lastInsertId());
            return true;
        }
        else
        {
            return false;
        }
    }

    public function updatePublication()
    {
        $result = $this->getDb()->query("UPDATE publication SET name = '".$this->getName()."', abstract = '".$this->getAbstract()."', year = '".$this->getYear()."', file = '".$this->getFile()."' WHERE publicationId = '".$this->getId()."'");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function deletePublication()
    {
        $result = $this->getDb()->query("DELETE FROM publication WHERE publicationId = '".$this->getId()."'");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param mixed $abstract
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }

    /**
     * @return mixed
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * @param mixed $authors
     */
    public function setAuthors($authors)
    {
        $this->authors = $authors;
    }

    /**
     * @return mixed
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
     * @param mixed $projects
     */
    public function setProjects($projects)
    {
        $this->projects = $projects;
    }

    /**
     * @return mixed
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $uploaded
     */
    public function setUploaded($uploaded)
    {
        $this->uploaded = $uploaded;
    }

    /**
     * @return mixed
     */
    public function getUploaded()
    {
        return $this->uploaded;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    //Database

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