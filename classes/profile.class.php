<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 01/02/14
 * Time: 18:59
 */

class profile
{
    private $db;

    private $username;
    private $real_name;
    private $email;
    private $website;
    private $bio;
    private $linkedIn;
    private $twitter;
    private $scholar;
    private $photo;
    private $role;

    public function __construct($db,$username)
    {
        $this->db = $db;
        $this->username = $username;
        if($username != NULL)
        {
            $this->getProfile();
        }
    }

    public function createProfile()
    {
        //This function will only be called by the User Class to prevent multiple profiles being created for one user.
        $result = $this->db->exec("INSERT INTO ".$this->db->getPrefix()."profile (username,real_name,email,website,bio,linkedin,twitter,scholar,photo,role) VALUES ('".$this->getUsername()."','".$this->getRealName()."','".$this->getEmail()."','".$this->getWebsite()."','".$this->getBio()."','".$this->getLinkedIn()."','".$this->getTwitter()."','".$this->getScholar()."','".$this->getPhoto()."','".$this->getRole()."')");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getProfile()
    {
        $result = $this->db->query("SELECT * FROM ".$this->db->getPrefix()."profile WHERE username = '".$this->getUsername()."'");
        if($result)
        {
            $data = $result->fetch();
            $this->setRealName($data['real_name']);
            $this->setEmail($data['email']);
            $this->setWebsite($data['website']);
            $this->setBio($data['bio']);
            $this->setTwitter($data['twitter']);
            $this->setScholar($data['scholar']);
            $this->setPhoto($data['photo']);
            $this->setRole($data['role']);
            $this->setLinkedIn($data['linkedin']);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function updateProfile()
    {
        $result = $this->db->query("UPDATE ".$this->db->getPrefix()."profile SET real_name = '".$this->getRealName()."', email = '".$this->getEmail()."', website = '".$this->getWebsite()."', bio = '".$this->getBio()."', linkedin = '".$this->getLinkedin()."', twitter = '".$this->getTwitter()."', scholar = '".$this->getScholar()."', photo = '".$this->getPhoto()."', role = '".$this->getRole()."' WHERE username = '".$this->getUsername()."'");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getProjects()
    {
        $result = $this->db->query("SELECT projectId FROM project_collaborator WHERE username = '".$this->getUsername()."'");
        if($result)
        {
            $projects = array();
            while($data = $result->fetch())
            {
                $project = new Project($this->getDb(),$data['projectId']);
                if($project->getProject())
                {
                    $projects[] = $project;
                }
            }
            return $projects;
        }
    }

    public function getPublications()
    {
        $result = $this->db->query("SELECT publicationId FROM publication_author WHERE username = '".$this->getUsername()."'");
        if($result)
        {
            $publications = array();
            while($data = $result->fetch())
            {
                $publication = new Publication($this->getDb(),$data['publicationId']);
                if($publication->getPublication())
                {
                    $publications[] = $publication;
                }
            }
            return $publications;
        }
    }

    /**
     * @param mixed $bio
     */
    public function setBio($bio)
    {
        $this->bio = $bio;
    }

    /**
     * @return mixed
     */
    public function getBio()
    {
        return $this->bio;
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
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $linkedIn
     */
    public function setLinkedIn($linkedIn)
    {
        $this->linkedIn = $linkedIn;
    }

    /**
     * @return mixed
     */
    public function getLinkedIn()
    {
        return $this->linkedIn;
    }

    /**
     * @param mixed $real_name
     */
    public function setRealName($real_name)
    {
        $this->real_name = $real_name;
    }

    /**
     * @return mixed
     */
    public function getRealName()
    {
        return $this->real_name;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $scholar
     */
    public function setScholar($scholar)
    {
        $this->scholar = $scholar;
    }

    /**
     * @return mixed
     */
    public function getScholar()
    {
        return $this->scholar;
    }

    /**
     * @param mixed $twitter
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * @return mixed
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
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

    public function getFullPhoto()
    {
        $file = "images/profile/".$this->photo;
        if(file_exists($file) && strlen($this->getPhoto()) > 0)
        {
            return $file;
        }
        else
        {
            return "images/test-profile.jpg";
        }
    }

    public function generateProfileLink()
    {
       $link = "<a href='?mode=profile&user=".$this->getUsername()."'><img id='".$this->getUsername()."_tooltip' class='img-thumbnail profile' style='max-width:75px;max-height:75px;' src='".$this->getFullPhoto()."' data-toggle='tooltip' title='<b>".$this->getRealName()."</b><br /><em>".$this->getRole()."</em>' /></a>";
       return $link;
    }


} 