<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 17/03/14
 * Time: 22:29
 */

class News
{
    private $db;

    private $id;
    private $title;
    private $author;
    private $summary;
    private $content;
    private $created;
    private $image;

    public function __construct($db,$id)
    {
        $this->setId($id);
        $this->setDb($db);
    }

    public function createNews()
    {
        $result = $this->getDb()->query("INSERT INTO news (author,title,summary,content,image) VALUES ('".$this->getAuthor()->getUsername()."','".$this->getTitle()."','".$this->getSummary()."','".$this->getContent()."','".$this->getImage()."')");
        if($result)
        {
            return true;
            $this->setId($this->getDb()->getDb()->lastInsertId());
        }
        else
        {
            return false;
        }
    }

    public function updateNews()
    {
        $result = $this->getDb()->query("UPDATE news SET author = '".$this->getAuthor()->getUsername()."', title = '".$this->getTitle()."', summary = '".$this->getSummary()."', content = '".$this->getContent()."', image = '".$this->getImage()."' WHERE newsId = '".$this->getId()."'");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function deleteNews()
    {
        $result = $this->getDb()->query("DELETE FROM news WHERE newsId = '".$this->getId()."'");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getNews()
    {
        $result = $this->getDb()->query("SELECT * FROM news WHERE newsId = '".$this->getId()."'");
        if($result)
        {
            $data = $result->fetch();
            $this->setAuthor(new Profile($this->getDb(),$data['author']));
            $this->setContent($data['content']);
            $this->setCreated($data['createdAt']);
            $this->setSummary($data['summary']);
            $this->setTitle($data['title']);
            $this->setImage($data['image']);
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
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
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
     * @param mixed $summary
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     * @return mixed
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    public function generateImage()
    {
        if(basename($_SERVER['PHP_SELF']) == "getNewsList.php")
        {
            $file = "../images/news/".$this->getImage();
            $actualFile = "images/news/".$this->getImage();
        }
        else
        {
            $file = "images/news/".$this->getImage();
            $actualFile = "images/news/".$this->getImage();
        }
        if(strlen($this->getImage()) > 0 && file_exists($file))
        {
            return "<img class='img-thumbnail' width='175' src='".$actualFile."' />";
        }
        else
        {
            return "<img class='img-thumbnail' width='175' src='images/logo.png' />";
        }
    }

    public function generateHomePageImage()
    {
        $file = "images/news/".$this->getImage();
        if(strlen($this->getImage()) > 0 && file_exists($file))
        {
            return "<img class='media-object' width='50' src='".$file."' />";
        }
        else
        {
            return "<img class='media-object' width='50' src='images/logo.png' />";
        }
    }


    
} 