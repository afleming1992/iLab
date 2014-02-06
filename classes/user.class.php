<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 01/02/14
 * Time: 14:37
 */

class user {
    private $db; //Storing the Database Object in this

    private $username;
    private $password;
    private $access_level;
    private $hidden;
    private $salt;
    private $profile;

    public function __construct($db,$username)
    {
        $this->setDb($db);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setProfile(new Profile($this->db,$this->username));
    }

    public function createUser()
    {
        $this->setNewSalt();
        $this->setPassword(md5($this->getSalt()."".$this->getPassword()));
        $result = $this->db->exec("INSERT INTO ".$this->db->getPrefix()."user (username,password,access_level,hidden) VALUES ('$this->getUsername()','$this->getRealName()','$this->getPassword()','$this->getAccessLevel()','$this->getHidden()','$this->getSalt()')");
        if($result)
        {
            $result = $this->getProfile()->createProfile();
            if($result)
            {
                return true;
            }
            else
            {
                //Roll Back
                $this->db->exec("DELETE FROM ".$this->db->getPrefix()."user WHERE username = '$this->getUsername'");
            }
        }
        else
        {
            return false;
        }
    }

    public function updateUser()
    {
        $result = $this->db->exec("UPDATE ".$this->db->getPrefix()."user SET password = '$this->getPassword()', access_level = '$this->getPassword()', hidden = '$this->getHidden()', salt = '$this->getSalt()' WHERE username = '$this->getUsername()' ");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    public function checkPassword()
    {
        $result = $this->db->query("SELECT * FROM user where username = '". $this->getUsername() ."'");
        if($data = $result->fetch())
        {
            //We get our Salt from the Database (As it's Randomly Generated for each user and when they change their Password)
            $this->setSalt($data['salt']);
            $this->setPassword(md5($this->getSalt()."".$this->getPassword()));
            if($result != false && $this->password == $data['password'])
            {
                $this->setAccessLevel($data['access_level']);
                $this->setHidden($data['hidden']);
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public function getUser()
    {
        $result = $this->db->query("SELECT * FROM user WHERE username = '".$this->getUsername()."'");
        if($data = $result->fetch())
        {
            $this->setAccessLevel($data['access_level']);
            $this->setHidden($data['hidden']);
            return true;
        }
        else
        {
            return false;
        }

    }

    public function updatePassword($newPassword)
    {
        $this->setNewSalt();
        $this->setPassword(md5($this->getSalt()."".$newPassword));
    }

    //Getters and Setters
    /**
     * @param mixed $access_level
     */
    public function setAccessLevel($access_level)
    {
        $this->access_level = $access_level;
    }

    /**
     * @return mixed
     */
    public function getAccessLevel()
    {
        return $this->access_level;
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
     * @param mixed $hidden
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * @return mixed
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
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
     * @param mixed $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function setNewSalt()
    {
        $this->salt = mycrypt_create_iv(32);
    }

    /**
     * @return mixed
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param mixed $profile
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    }

    /**
     * @return mixed
     */
    public function getProfile()
    {
        return $this->profile;
    }

} 