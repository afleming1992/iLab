<?php
    include("../config/config.php"); //include config file
    include("../classes/Database.class.php");

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

    if(isset($_POST['project']))
    {
        if(strlen($_POST['project']) > 0)
        {
        $queryArray[] = "publicationId IN (SELECT publicationId FROM publication_project WHERE projectId = '".$_POST['project']."')";
        }
    }

    if(isset($_POST['author']))
    {
        if(strlen($_POST['author']) > 0)
        {
            $queryArray[] = "publicationId IN (SELECT publicationId FROM publication_author WHERE username = '".$_POST['author']."')";
        }
    }

    if(isset($_POST['title']))
    {
        if(strlen($_POST['title']) > 0)
        {
            $queryArray[] = "name LIKE '%".$_POST['title']."%'";
        }
    }

    if(isset($_POST['username']))
    {
        if(strlen($_POST['username']))
        {
            $queryArray[] = "publicationId in (SELECT publicationId FROM publication_author WHERE username = '".$_POST['username']."')";
        }
    }

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
            $first = false;
        }
    }
    $query = "SELECT * FROM publication ".$where." ORDER BY year DESC LIMIT ".$position.", ".$item_per_page;

    $results = $db->query($query);

//output results from database
    while($row = $results->fetch())
    {
        $output = "<a href='?mode=publication&id=".$row['publicationId']."'><div class='well'>";

        $authorResults = $db->query("SELECT * FROM publication_author WHERE publicationId = '".$row['publicationId']."'");
        $first = true;
        while($author = $authorResults->fetch())
        {
            if(!$first)
            {
                $output .= ", ";
            }
            $first = false;
            if($author['username'] == "null" || strlen($author['username']) == 0)
            {
                $output .= $author['nameOfAuthor']." ";
            }
            else
            {
                $RealNameResult = $db->query("SELECT real_name FROM profile WHERE username = '".$author['username']."'");
                if($RealNameResult)
                {
                    $realname = $RealNameResult->fetch();
                    $output .= $realname['real_name']." ";
                }
            }
        }
        $title = "<b>".$row['name']."</b>";
        $year = "<em>(".$row['year'].")</em>";
        if(strlen($row['publishedIn']) > 0)
        {
            $publishedIn = $row['publishedIn'];
        }
        $output .= $year." ".$title.", <em>".$publishedIn."</em>, ".$row['publisher']."</div></a>";
        echo $output;
    }