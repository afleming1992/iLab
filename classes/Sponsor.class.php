<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 14/02/14
 * Time: 22:04
 */

class Sponsor
{
    private $db;

    private $id;
    private $name;
    private $logo;
    private $website;

    public function __construct($db,$id)
    {
        $this->setDb($db);
        $this->setId($id);
    }

    public function createSponsor()
    {
        $result = $this->getDb()->query("INSERT INTO sponsor (name,logo,website) VALUES ('".$this->getName()."','".$this->getLogo()."','".$this->getWebsite()."')");
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

    public function addLink($projectId,$type)
    {
        $query = "INSERT INTO project_sponsor (projectId,sponsorId,type) VALUES ('$projectId','".$this->getId()."','$type')";
        //print($query);
        $result = $this->getDb()->query($query);
        if($result)
        {
            return true;
        }
        else
        {
            print("Add Fail");
            return false;
        }
    }

    public function removeLink($projectId)
    {
        $result = $this->getDb()->query("DELETE FROM project_sponsor WHERE projectId = '$projectId' AND sponsorId = '".$this->getId()."'");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getSponsor()
    {
        $result = $this->getDb()->query("SELECT * FROM sponsor WHERE sponsorId = '".$this->getId()."'");
        if($result)
        {
            $data = $result->fetch();
            $this->setName($data['name']);
            $this->setLogo($data['logo']);
            $this->setWebsite($data['website']);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function updateSponsor()
    {
        $result = $this->getDb()->query("UPDATE sponsor SET name='".$this->getName()."', logo = '".$this->getLogo()."', website = '".$this->getWebsite()."' WHERE sponsorId = '".$this->getId()."'");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function deleteSponsor()
    {
        $result = $this->getDb()->query("DELETE FROM sponsor WHERE sponsor_id = '".$this->getId()."'");
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
        return "images/sponsor/".$this->logo;
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



}