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
    private $logo;

    private $sponsors;
    private $partners;

    private $contributors;

    public function __construct($db,$id)
    {
        $this->setDb($db);
        $this->setId($id);
    }

    public function createProject()
    {
        $result = $this->getDb()->query("INSERT INTO project (name,description,website,startDate,endDate,logo) VALUES ('".$this->getName()."','".$this->getDescription()."','".$this->getWebsite()."','".$this->getStartDate()."','".$this->getEndDate()."','".$this->getLogo()."')");
        if($result)
        {
            $this->setId($this->getDb()->getDb()->lastInsertId());
            return true;
        }
        else
        {
            return false;
        }
    }

    public function updateProject()
    {
        $result = $this->getDb()->query("UPDATE project SET name = '".$this->getName()."',description = '".$this->getDescription()."', website = '".$this->getWebsite()."', startDate = '".$this->getStartDate()."', endDate = '".$this->getEndDate()."', logo = '".$this->getLogo()."' WHERE projectId = '".$this->getId()."'");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getProject()
    {
        $result = $this->getDb()->query("SELECT * FROM project WHERE projectId = '".$this->getId()."'");
        if($data = $result->fetch())
        {
            $this->setName($data['name']);
            $this->setDescription($data['description']);
            $this->setWebsite($data['website']);
            $this->setStartDate($data['startDate']);
            $this->setEndDate($data['endDate']);
            $this->setLogo($data['logo']);
            $this->setContributors($this->findContributors());
            $this->setSponsors($this->findPartners());
            return true;
        }
        else
        {
            return false;
        }
    }

    public function deleteProject()
    {
        $result = $this->getDb()->query("DELETE FROM project WHERE projectId = '".$this->getId()."'");
        if($result)
        {
            $this->cleanUp();
            return true;
        }
        else
        {
            return false;
        }
    }

    public function cleanUp()
    {
        $this->getDb()->query("DELETE FROM project_collaborator WHERE projectId = '".$this->getId()."'");
        $this->getDb()->query("DELETE FROM project_sponsor WHERE projectId = '".$this->getId()."'");
        $this->getDb()->query("DELETE FROM publication_project WHERE projectId = '".$this->getId()."'");
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
                $contributor["user"] = new User($this->getDb(),$data['username']);
                $contributor["user"]->getProfile()->getProfile();
                $contributor["admin"] = $data['admin'];
                $contributor["hidden"] = $data['hidden'];
                $contributors[] = $contributor;
            }
        }
        return $contributors;
    }

    public function findNonContributors()
    {
        $result = $this->getDb()->query("SELECT * FROM user WHERE username NOT IN (SELECT username FROM project_collaborator WHERE projectId = '".$this->getId()."')");
        $nonContributors = array();
        if($result)
        {
            while($data = $result->fetch())
            {
                $user = new User($this->getDb(),$data['username']);
                $user->getProfile()->getProfile();
                $nonContributors[] = $user;
            }
        }
        return $nonContributors;
    }

    public function checkIfAdmin($username)
    {
        $contributors = $this->getContributors();
        foreach($contributors as $contributor)
        {
            if(strcmp($username,$contributor['user']->getUsername()) == 0 && $contributor['admin'] == 1)
            {
                return true;
            }
        }
        return false; //Subject not Found
    }

    public function findPartners()
    {
        $sponsors = array();
        $result = $this->getDb()->query("SELECT * FROM project_sponsor WHERE projectId = '".$this->getId()."'");
        if($result)
        {
            while($data = $result->fetch())
            {
                $sponsor = array();
                $sponsor["sponsor"] = new Sponsor($this->getDb(),$data['sponsorId']);
                $sponsor["sponsor"]->getSponsor();
                $sponsors[] = $sponsor;
            }
        }
        return $sponsors;
    }

    public function addCollaborator($username,$admin,$hidden)
    {
        $result = $this->getDb()->query("INSERT INTO project_collaborator (username,projectId,admin,hidden) VALUES ('$username','".$this->getId()."','$admin','$hidden')");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function findPublications()
    {
        $result = $this->getDb()->query("SELECT * FROM publication_project WHERE projectId = '".$this->getId()."'");
        $publications = array();
        if($result)
        {
            while($data = $result->fetch())
            {
                $publication = new Publication($this->getDb(),$data['publicationId']);
                if($publication->getPublication())
                {
                    $publications[] = $publication;
                }
            }
        }
        return $publications;
    }

    public function removeCollaborator($username)
    {
        $result = $this->getDb()->query("DELETE FROM project_collaborator WHERE projectId = '".$this->getId()."' AND username = '$username'");
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

    public function setContributors($contributors)
    {
        $this->contributors = $contributors;
    }

    /**
     * @return mixed
     */
    public function getContributors()
    {
        return $this->contributors;
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

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function sqlToNormal($date)
    {
        $date = explode("-",$date);
        return $date[2]."/".$date[1]."/".$date[0];
    }

    public function normalToSql($date)
    {
        $date = explode("/",$date);
        return $date[2]."-".$date[1]."-".$date[0];
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

    /**
     * @param mixed $partners
     */
    public function setPartners($partners)
    {
        $this->partners = $partners;
    }

    /**
     * @return mixed
     */
    public function getPartners()
    {
        return $this->partners;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    public function getFullLogo()
    {
        $file = "images/project/".$this->getLogo();
        if(file_exists($file) && strlen($this->getLogo()) > 0)
        {
            return $file;
        }
        else
        {
            return "images/test-project.jpg";
        }
    }

    public function generateLink()
    {
        $photo = $this->getFullLogo();
        $link = "<a href='?mode=project&id=".$this->getId()."'><img class='img-thumbnail profile' style='max-width:200px; max-height:200px;' src='".$photo."' /></a><script></script>";
        return $link;
    }
} 