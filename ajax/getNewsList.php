<?php
    include("../config/config.php"); //include config file
    include("../classes/Database.class.php");
    include("../classes/News.class.php");
    include("../classes/Profile.class.php");

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

    $query = "SELECT * FROM news ORDER BY createdAt DESC LIMIT ".$position.", ".$item_per_page;

    $results = $db->query($query);

//output results from database
    while($row = $results->fetch())
    {
        $news = new News($db,$row['newsId']);
        $output = "";
        if($news->getNews())
        {
            $authorResults = $db->query("SELECT * FROM profile WHERE username = '".$row['author']."'");

            $image = $news->generateImage(true);

            $date = date("D d F Y",strtotime($news->getCreated()));

            $output = "<a href='?mode=news&id=".$news->getId()."'>";
            $output .= "<div class='well'><div class='row'>";
            $output .= "<div class='col-md-4'>".$image."</div>";
            $output .= "<div class='col-md-8'><b>".$news->getTitle()."</b><br /><em><small>".$date."</small></em><p>".html_entity_decode($news->getSummary(),ENT_QUOTES)."</p></div>";
            $output .= "</div></div>";
            $output .= "</a>";

        }
        echo $output;
    }