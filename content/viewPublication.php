<div class="row col-md-14">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">
                    Navigation
                </h1>
            </div>
            <div class="panel-body" style="padding:0">
                <?php
                    echo $sideNav;
                ?>
            </div>
        </div>
        <?php
            if($admin || $_SESSION['access_level'] > 1)
            {
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1 class="panel-title">
                            Administration
                        </h1>
                    </div>
                    <div class="panel-body" style="padding:0">
                        <?php
                            echo $adminSection;
                        ?>
                    </div>
                </div>
            <?php
            }
        ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title"><?php echo $publication->getName(); ?></h2>
            </div>
            <div class="panel-body">
                <div style="bottom:0" class="row">
                    <div style="display:table-cell;height:100%" class="col-md-4">
                        <div class="well" style="min-height:100%">
                            <h4>Year - <?php echo $publication->getYear() ?></h4>
                            <?php
                                if(strlen($publication->getPublishedIn()) > 0)
                                {
                                    ?>
                                        <p>Published In <?php echo $publication->getPublishedIn(); ?></p>
                            <?php
                                }

                                if(strlen($publication->getPublisher()) > 0)
                                {
                                ?>
                            <p><em>Publisher</em> <br /><?php echo $publication->getPublisher(); ?></p>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                    <div style="right:0" class="col-md-8">
                        <div class="well">
                            <h4>Authors</h4>
                            <?php
                                $authors = $publication->getAuthors();
                                $ilabAuthors = "";
                                $nonAuthors = "";
                                foreach($authors as $author)
                                {
                                    if(!is_string($author['author']))
                                    {
                                        $ilabAuthors .= $author['author']->getProfile()->generateProfileLink();
                                    }
                                    else
                                    {
                                        if(strlen($nonAuthors) > 0)
                                        {
                                            $nonAuthors .= ", ".$author['author'];
                                        }
                                        else
                                        {
                                            $nonAuthors = $author['author'];
                                        }
                                    }
                                }
                                echo $ilabAuthors;
                                ?>
                                    <h5>Other Authors</h5>
                                <?php
                                echo $nonAuthors;
                            ?>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $(".profile").tooltip({
                                        'html': true
                                    })
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php
                        if(count($projects) > 0)
                        {
                    ?>
                    <div class="col-md-12">
                        <div class="well">
                            <h4>This Publication is associated with:</h4>
                            <?php
                                 foreach($projects as $project)
                                 {
                                     echo $project->generateLink();
                                 }
                            ?>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                            if(strlen($publication->getAbstract()) > 0)
                            {
                                ?>
                                    <div class="well">
                                        <h4>Abstract</h4>
                                        <?php echo $publication->getAbstract(); ?>
                                    </div>
                                <?php
                            }
                        ?>
                    </div>
                    <div class="col-md-12">
                        <?php
                            if(strlen($publication->getLink()) > 0)
                            {
                                ?>
                                    <div class="well">
                                        <a target="_blank" id="downloadButton" onClick="recordDownload(<?php echo $publication->getId(); ?>)" class="btn btn-block btn-primary" href="<?php echo $publication->getLink() ?>">Download Publication</a>
                                    </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Delete Modal -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete this Publication</h4>
            </div>
            <div class="modal-body">
                <h3>Are you sure you wish to delete this Publication?</h3>
                <br/><br />
                <a href='?mode=delete&type=publication&id=<?php echo $publication->getId(); ?>' class="btn btn-block btn-success">Yes</a><a href='' data-dismiss='modal' class="btn btn-block btn-danger">No</a>
            </div>
        </div>
    </div>
</div>
<!-- Stats Modal -->
<div class="modal fade" id="stats" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Stats for this Publication</h4>
            </div>
            <div class="modal-body">
                <div class="center-block" style="margin-left:auto;margin-right:auto;">
                <canvas id="myChart" width="558" height="400"></canvas>
                    <script>
                        var ctx = $("#myChart").get(0).getContext("2d");
                        //This will get the first returned node in the jQuery collection.
                        var data = {
                            <?php
                                for ($i = 11; $i >= 0; $i--)
                                {
                                     $months[] = date("M-Y", strtotime( date( 'Y-m-01' )." -$i months"));
                                }
                                $downloads = $publication->getDownloadsByMonth();
                            ?>
                            labels : [
                             <?php
                                $first = true;
                                foreach($months as $month)
                                {
                                    if(!$first)
                                    {
                                        echo ",";
                                    }
                                    echo "'".$month."'";
                                    $first = false;
                                }
                             ?>
                            ],
                            datasets : [
                                {
                                    fillColor : "rgba(151,187,205,0.5)",
                                    strokeColor : "rgba(151,187,205,1)",
                                    pointColor : "rgba(151,187,205,1)",
                                    pointStrokeColor : "#fff",
                                    data :
                                    [
                                    <?php
                                        $first = true;
                                        $highest = -1;
                                        foreach($downloads as $download)
                                        {
                                            if(!$first)
                                            {
                                                echo ",";
                                            }
                                            echo $download;
                                            if($download > $highest)
                                            {
                                                $highest = $download;
                                            }
                                            $first = false;
                                        }
                                    ?>
                                    ]
                                }
                            ]
                        }
                        var options = {
                            animation : true,
                            scaleStepWidth : 1
                        }

                        var myNewChart = new Chart(ctx).Line(data,options);

                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function recordDownload(publication)
    {
        $("#downloadButton").html("<img width='50' height='50' src='images/loading.gif' />Loading...");
        var dataString = "pubId="+ publication;
        $.ajax({
            type: "POST",
            url: "ajax/recordDownload.php",
            data : dataString,
            dataType: "xml",
        });
        $("#downloadButton").html("Download Publication");
        return true;
    }
</script>
