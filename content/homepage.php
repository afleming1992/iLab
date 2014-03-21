<div class="container-fluid">
<div class="row col-md-14">
    <div class='col-md-8 col-xs-12' style='float:left'>
        <div class="panel panel-default">
            <div class="panel-body">
                <?php
                    include('carousel.php');
                ?>
            </div>
        </div>
    </div>

    <div class='col-md-4 col-xs-12' style='float:right'>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">
                    News
                </h3>
            </div>
            <div class="panel-body">
                <?php
                    foreach($articles as $article)
                    {
                    ?>

                        <div class="media news">
                            <a href="?mode=news&id=<?php echo $article->getId(); ?>">
                            <span class="pull-left"><?php echo $article->generateHomePageImage(); ?></span>
                        <div class="media-body">
                            <h5 class="media-heading"><?php echo $article->getTitle() ?></h5>
                            <?php echo $article->getSummary(); ?>
                        </div>
                            </a>
                    </div>

                    <?php
                    }
                ?>
                <br />
                <a href="?mode=news" class="btn btn-sm btn-success btn-block">More News</a>
            </div>
        </div>
    </div>
</div>

<div class="row col-md-14">
    <div class='col-md-4'>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Latest Publications</h3>
            </div>
            <div class="panel-body">
                <?php
                    foreach($publications as $publication)
                    {
                        echo $publication->generateLink();
                    }
                ?>
                <a class="btn btn-sm btn-block btn-success" href="?mode=publication">More Publications</a>
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Who we are
                </h3>
            </div>
            <div class="panel-body">
                <div style="text-align:center">
                <?php
                    foreach($users as $user)
                    {
                        echo $user->generateProfileLink();
                    }
                ?>
                <br />
                <a class="btn btn-sm btn-block btn-success" href="">Our Full Team</a>
                </div>
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Current Projects</h3>
            </div>
            <div class="panel-body">
                <?php
                    foreach($projects as $project)
                    {
                        echo $project->generateLink();
                    }
                ?>
                <a class="btn btn-sm btn-block btn-success" href="?mode=project">More Projects</a>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".profile").tooltip({
            'html': true
        })
    });
</script>