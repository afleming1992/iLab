<?php
include("../config/config.php");
include("../classes/Database.class.php");
include("../classes/Publication.class.php");

$db = new Database($server,$database,$user,$password,$table_prefix);

$publication = new Publication($db,$_POST['pubId']);
$ip = $_SERVER['REMOTE_ADDR'];
if($publication->getPublication())
{
    $downloaded = $publication->checkIfDownloaded($ip);
    if($downloaded)
    {
        $error = $publication->recordDownload($ip);
        if($error != true)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}