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
            if($_SESSION['access_level'] >= 1 || (strcmp($_SESSION['username'],$news->getAuthor()->getUsername()) == 0))
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title"><?php echo $news->getTitle(); ?></h1>
            </div>
            <div class="panel-body">
                <small>Posted by <?php echo $news->getAuthor()->getRealName() ?> on <?php echo $date; ?></small>
                 <div class="row">
                    <div class="col-md-8">
                        <div class="jumbotron news-summary">
                            <?php
                                echo html_entity_decode($news->getSummary(),ENT_QUOTES);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <?php
                           $image = $news->generateImage();
                            echo $image;
                        ?>
                    </div>

                </div>
                <p>
                    <?php
                        echo html_entity_decode($news->getContent(),ENT_QUOTES);
                    ?>
                </p>
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
                <h4 class="modal-title" id="myModalLabel">Delete News Article</h4>
            </div>
            <div class="modal-body">
                <h4>Are you absolutely sure you wish to delete this News Item?</h4>
                <a class="btn btn-success btn-block" href="?mode=delete&type=news&id=<?php echo $news->getId() ?>">Yes</a>
                <a class="btn btn-danger btn-block" data-dismiss="modal" href="#">No</a>
            </div>
        </div>
    </div>
</div>