<?php
    include("../config/config.php"); //include config file
    include("../classes/Database.class.php");
    include("../classes/Project.class.php");

    if(isset($_POST['numberPerPage']))
    {
        $item_per_page = $_POST['numberPerPage'];
    }
    else
    {
        $item_per_page = 10;
    }

    $db = new Database($server, $database, $user, $password, $table_prefix);


//sanitize post value
    $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

//validate page number is really numaric
    if(!is_numeric($page_number)){die('Invalid page number!');}

//get current starting point of records
    $position = ($page_number * $item_per_page);

//Limit our results within a specified range.
    $queryArray = array();

    /*if(isset($_POST['project']))
    {
        if(strlen($_POST['project']) > 0)
        {
            $queryArray[] = "publicationId IN (SELECT publicationId FROM publication_project WHERE projectId = '".$_POST['project']."')";
        }
    }*/


    $where = "";
    if(count($queryArray) > 0)
    {
        $where = "WHERE ";
        $first = true;
        for($i = 0;$i < count($queryArray);$i++)
        {
            if(!$first)
            {
                $where .= "AND ";
            }
            $where .= $queryArray[$i];
        }
    }
    $query = "SELECT * FROM project ".$where." ORDER BY startDate DESC, title ASC LIMIT ".$position.", ".$item_per_page;

    $results = $db->query($query);

//output results from database
    $output = "";
    while($row = $results->fetch())
    {
        $project = new Project($db,$row['projectId']);
        $output .= $project->generateLink();
    }
    echo $output;