<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 11/02/14
 * Time: 23:34
 */

class Project {

    private $db;

    private $id;
    private $name;
    private $description;
    private $website;
    private $startDate;
    private $endDate;

    private $sponsors;
    private $partners;

    private $contributors;

    public function __construct($db,$id)
    {
        $contributors = array();
        $sponsors = array();
        $this->setDb($db);
        $this->setId($id);
    }

    public function getProject()
    {
        $result = $this->getDb()->query("SELECT * FROM project WHERE project_Id = '".$this->getId()."'");
        if($result)
        {
            $data = $result->fetch();
            $this->setName($data['name']);
            $this->setDescription($data['description']);
            $this->setWebsite($data['website']);
            $this->setStartDate($data['startDate']);
            $this->setEndDate($data['endDate']);
            $this->setContributors($this->findContributors());
        }
        else
        {
            return false;
        }
    }

    public function findContributors()
    {
        $contributors = array();
        $result = $this->getDb()->query("SELECT * FROM project_collaborator WHERE projectId = '".$this->getId()."'");
        if($result)
        {
            while($data = $result->fetch())
            {
                $contributor = array();
                $contributor[] = new User($this->getDb(),$data['username']);
                $contributor[] = $data['admin'];
                $contributor[] = $data['hidden'];
                $contributors[] = $contributor;
            }
        }
        return $contributors;
    }

    public function findSponsors()
    {
        $sponsors = array();
        $result = $this->getDb()->query("SELECT * FROM project_sponsor WHERE projectId = '".$this->getId()."' AND type = 'sponsor'");
        if($result)
        {
            while($data = $result->fetch())
            {

            }
        }
    }

    public function findPartners()
    {

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
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
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
     * @param mixed $staff
     */
    public function setContributors($staff)
    {
        $this->staff = $staff;
    }

    /**
     * @return mixed
     */
    public function getContributors()
    {
        return $this->staff;
    }

    /**
     * @param mixed $sponsors
     */
    public function setSponsors($sponsors)
    {
        $this->sponsors = $sponsors;
    }

    /**
     * @return mixed
     */
    public function getSponsors()
    {
        return $this->sponsors;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }


} 