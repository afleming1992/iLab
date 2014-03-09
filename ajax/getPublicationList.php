<?php
    include("../config/config.php"); //include config file
    include("../classes/Database.class.php");

    $db = new Database($server, $database, $user, $password, $table_prefix);
    $item_per_page = 5;

//sanitize post value
    $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

//validate page number is really numaric
    if(!is_numeric($page_number)){die('Invalid page number!');}

//get current starting point of records
    $position = ($page_number * $item_per_page);

//Limit our results within a specified range.

    $results = $db->query("SELECT * FROM publication ORDER BY year DESC LIMIT ".$position.", ".$item_per_page);

//output results from database
    while($row = $results->fetch())
    {
        $output = "<a href='?mode=publication&id=".$row['publicationId']."'><div class='well'><b>".$row['name']."</b><br />";

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
                $output .= $author['nameOfAuthor'];
            }
            else
            {
                $RealNameResult = $db->query("SELECT real_name FROM profile WHERE username = '".$author['username']."'");
                if($RealNameResult)
                {
                    $realname = $RealNameResult->fetch();
                    $output .= $realname['real_name'];
                }
            }
        }
        $output .= "<em> ".$row['year']."</em>";
        if(strlen($row['publishedIn']) > 0)
        {
            $output .= " In: ".$row['publishedIn'];
        }
        $output .= "</div></a>";
        echo $output;
    }