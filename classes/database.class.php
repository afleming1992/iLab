<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 01/02/14
 * Time: 14:49
 */#

class Database
{
    private $db;
    private $prefix;

    public function __construct($server, $database, $user, $password,$prefix)
    {
        try
        {
            $this->setDb(new PDO("mysql:host=$server;dbname=$database",$user,$password));
            $this->setPrefix($prefix);
        }
        catch(Exception $e)
        {
            echo "Error:- PDO Connection Error". $e->getMessage();
            die();
        }
    }

    public function query($statement)
    {
        if($result=$this->db->query($statement))
        {
            return $result;
        }
        else
        {
            $error = $this->getDb()->errorInfo();
            print("DATABASE ERROR:".$error[2]);
            return false;
        }
    }

    public function exec($statement)
    {
        if($this->db->exec($statement) > 0)
        {
            return true;
        }
        else
        {
            print($statement);
            $error = $this->getDb()->errorInfo();
            print("DATABASE ERROR:".$error[2]);
            return false;
        }
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    public function getDb()
    {
        return $this->db;
    }

    public function setDb($db)
    {
        $this->db = $db;
    }

} 