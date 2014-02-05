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
    $server = "localhost";
    $database = "swfm_ilab";
    $user = "swfm_1";
    $password = "smallfm1992";
    $table_prefix = "";
}