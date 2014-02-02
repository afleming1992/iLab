<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 01/02/14
 * Time: 18:43
 */

class Page {
    private $db;

    private $pageId;
    private $section;
    private $author;
    private $title;
    private $content;
    private $restricted;
    private $time_created;
    private $time_last_updated;
    private $module;

    public function __construct($db,$pageId)
    {
        $this->setDB($db);
        $this->setPageId($pageId);
    }

    public function getPageDetails()
    {
        $result = $this->db->query("SELECT * FROM ".$this->db->getPrefix()."page WHERE page_id = '".$this->getPageId()."'");
        $rowCount = $result->rowCount();
        $data = $result->fetch();
        if($rowCount == 1)
        {
            $this->setSection(new Section($this->db,$data['section']));
            $this->getSection()->getDetails();
            $this->setAuthor(new Profile($this->db,$data['author']));
            $this->getAuthor()->getProfile();
            $this->setTitle($data['title']);
            $this->setContent($data['content']);
            $this->setRestricted($data['restricted']);
            $this->setTimeCreated($data['time_created']);
            $this->setTimeLastUpdated($data['time_last_updated']);
            $this->setModule($data['module']);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function updatePage()
    {
        $result = $this->db->exec("UPDATE ".$this->db->getPrefix()."page SET section = ");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function deletePage()
    {
        $result = $this->db->exec("DELETE FROM ".$this->db->getPrefix()."page WHERE pageId = ".$this->getPageId());
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //
    //GETTERS/SETTERS
    //

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
     * @param mixed $time_last_updated
     */
    public function setTimeLastUpdated($time_last_updated)
    {
        $this->time_last_updated = $time_last_updated;
    }

    /**
     * @return mixed
     */
    public function getTimeLastUpdated()
    {
        return $this->time_last_updated;
    }

    /**
     * @param mixed $time_created
     */
    public function setTimeCreated($time_created)
    {
        $this->time_created = $time_created;
    }

    /**
     * @return mixed
     */
    public function getTimeCreated()
    {
        return $this->time_created;
    }

    /**
     * @param mixed $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * @return mixed
     */
    public function getSection()
    {
        return $this->section;
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
     * @param mixed $pageId
     */
    public function setPageId($pageId)
    {
        $this->pageId = $pageId;
    }

    /**
     * @return mixed
     */
    public function getPageId()
    {
        return $this->pageId;
    }

    /**
     * @param mixed $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
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
} 