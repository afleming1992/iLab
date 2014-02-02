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

    public function  _construct($server, $database, $user, $password,$prefix)
    {
        try
        {
            $this->db = new PDO("mysql:host=$server;dbname=$database",$user,$password);

        }
        catch(Exception $e)
        {
            echo "Error:- PDO Connection Error". $e->getMessage();
            die();
        }
    }

    public function query($statement)
    {
        $result=$this->db->query($statement);
        return $result;
    }

    public function exec($statement)
    {
        $this->db->exec($statement);
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

} 