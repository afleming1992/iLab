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
    private $link;
    private $publisher;
    private $publishedIn;

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
        $result = $this->getDb()->query("INSERT INTO publication (name,year,abstract,publishedIn,publisher,file) VALUES ('".$this->getName()."','".$this->getYear()."','".$this->getAbstract()."','".$this->getPublishedIn()."','".$this->getPublisher()."','".$this->getLink()."')");
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

    public function getPublication()
    {
        $result = $this->getDb()->query("SELECT * FROM publication WHERE publicationId = '".$this->getId()."'");
        if($result)
        {
            $data = $result->fetch();
            $this->setName($data['name']);
            $this->setYear($data['year']);
            $this->setUploaded($data['time_uploaded']);
            $this->setAbstract($data['abstract']);
            $this->setPublishedIn($data['publishedIn']);
            $this->setPublisher($data['publisher']);
            $this->setLink($data['file']);
            //Get Authors

            $this->findAuthors();
            return true;
        }
        else
        {
            return false;
        }
    }

    public function updatePublication()
    {
        $result = $this->getDb()->query("UPDATE publication SET name = '".$this->getName()."', abstract = '".$this->getAbstract()."', year = '".$this->getYear()."', file = '".$this->getLink()."', publisher = '".$this->getPublisher()."', publishedIn = '".$this->getPublishedIn()."' WHERE publicationId = '".$this->getId()."'");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function doCleanUp()
    {
        $result = $this->getDb()->query("DELETE FROM publication_author WHERE publicationId = '".$this->getId()."'");
        $result2 = $this->getDb()->query("DELETE FROM publication_project WHERE publicationId = '".$this->getId()."'");
        $result3 = $this->getDb()->query("DELETE FROM publication_download WHERE publicationId = '".$this->getId()."'");
        if($result && $result2 && $result3)
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
        $this->doCleanUp();
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

    public function addIlabAuthor($username)
    {
        $result = $this->getDb()->query("INSERT INTO publication_author (publicationId,username,nameOfAuthor) VALUES ('".$this->getId()."','".$username."',NULL)");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function addAuthor($name)
    {
        $result = $this->getDb()->query("INSERT INTO publication_author (publicationId,username,nameOfAuthor) VALUES ('".$this->getId()."',NULL,'".$name."')");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function checkIfAuthor($username)
    {
        $result = $this->getDb()->query("SELECT * FROM publication_author WHERE username = '".$username."'");
        if($result->rowCount() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function findAuthors()
    {
        $result = $this->getDb()->query("SELECT authorId, username, nameOfAuthor FROM publication_author WHERE publicationId = '".$this->getId()."'");
        $authors = array();
        if($result)
        {
            while($data = $result->fetch())
            {
                $author = array();
                if($data['username'] != null)
                {
                    $author['author'] = new User($this->getDb(),$data['username']);
                }
                else
                {
                    $author['author'] = $data['nameOfAuthor'];
                }
                $author['id'] = $data['authorId'];
                $authors[] = $author;
            }
        }
        $this->setAuthors($authors);
    }

    public function getNonAuthors()
    {
        $result = $this->getDb()->query("SELECT DISTINCT username FROM user WHERE username NOT IN (SELECT username FROM publication_author WHERE publicationId = '".$this->getId()."' and username is not null)");
        if($result)
        {
            $iLabUsers = array();
            while($data = $result->fetch())
            {
                $user = new User($this->getDb(),$data['username']);
                $user->getProfile();
                $iLabUsers[] = $user;
            }
            return $iLabUsers;
        }
        else
        {
            return false;
        }
    }

    public function getProjects()
    {
        $result = $this->getDb()->query("SELECT projectId FROM publication_project WHERE publicationId = '".$this->getId()."'");
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

    public function getNonProjects()
    {
        $result = $this->getDb()->query("SELECT * FROM project WHERE projectId NOT IN (SELECT projectId FROM publication_project WHERE publicationId = '".$this->getId()."' and projectId is not null);");
        $projects = array();
        if($result)
        {
            while($data = $result->fetch())
            {
                $project = new Project($this->getDb(),$data['projectId']);
                if($project->getProject());
                {
                    $projects[] = $project;
                }
            }
        }
        return $projects;
    }

    public function addProject($projectId)
    {
        $result = $this->getDb()->query("INSERT INTO publication_project (publicationId,projectId) VALUES ('".$this->getId()."','".$projectId."')");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function removeProject($projectId)
    {
        $result = $this->getDb()->query("DELETE FROM publication_project WHERE projectId = '".$projectId."' AND publicationId = '".$this->getId()."'");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function recordDownload($ip)
    {
        $result = $this->getDb()->query("INSERT INTO publication_download (publicationId,ip,date) VALUES ('".$this->getId(). "','".$ip."',CURDATE())");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getDownloadsByMonth()
    {
        $result = $this->getDb()->query("SELECT MONTH(date) as month,count(downloadID) as count FROM publication_download WHERE date >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH) GROUP BY MONTH(date) ORDER BY date ASC;");
        $downloads[] = array();
        for ($i = 11; $i >= 0; $i--)
        {
            $months[] = date("m", strtotime( date( 'Y-m-01' )." -$i months"));
        }

        $downloads = array();
        if($result)
        {
            $data = $result->fetch();
            $finished = false;
            for($i = 0;$i < 12;$i++)
            {
                if(!$finished)
                {
                    if($months[$i] == $data['month'])
                    {
                        $downloads[$i] = $data['count'];
                        if(($data = $result->fetch()))
                        {
                            $finished = true;
                        }
                    }
                    else
                    {
                        $downloads[$i] = 0;
                    }
                }
                else
                {
                    $downloads[$i] = 0;
                }
            }
            return $downloads;
        }
        else
        {
            return false;
        }
    }

    public function checkIfDownloaded($ip)
    {
        $result = $this->getDb()->query("SELECT * FROM publication_download WHERE publicationId = '".$this->getId()."' AND ip = '".$ip."'");
        if($result)
        {
            if($result->rowCount() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
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

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $publishedIn
     */
    public function setPublishedIn($publishedIn)
    {
        $this->publishedIn = $publishedIn;
    }

    /**
     * @return mixed
     */
    public function getPublishedIn()
    {
        return $this->publishedIn;
    }

    /**
     * @param mixed $publisher
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * @return mixed
     */
    public function getPublisher()
    {
        return $this->publisher;
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