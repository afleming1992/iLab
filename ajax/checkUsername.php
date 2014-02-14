<?php
include("../config/config.php");

if(isset($_POST['username']) && !empty($_POST['username']))
{
    $conn = mysql_connect($server,$user,$password) or die ("Database not connected");
    $db = mysql_select_db($database,$conn) or die("Database not connected");

    $username=strtolower(mysql_real_escape_string($_POST['username']));
    $query = "SELECT * FROM ".$table_prefix."user WHERE username = '$username'";
    $res = mysql_query($query);
    if(mysql_num_rows($res))
    {
        $HTML='user exists';
    }
    else
    {
        $HTML="";
    }
    echo $HTML;
}