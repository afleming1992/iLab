<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 01/02/14
 * Time: 22:03
 */
//print($_SERVER['SERVER_ADDR']);
if($_SERVER['SERVER_ADDR'] == "::1")
{
    $server = "localhost";
    $database = "ilab";
    $user = "root";
    $password = "";
    $table_prefix = "";
}
else
{
    $server = "mysql17.000webhost.com";
    $database = "a9214664_ilab";
    $user = "a9214664_ilab";
    $password = "SXrE8gF9";
    $table_prefix = "";
}