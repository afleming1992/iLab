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
            if($adminAuthorised || $_SESSION['access_level'] > 1)
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
                <h1 id='contentTitle' class="panel-title">
                    <?php
                        if($past == 1)
                        {
                            echo "Past Projects";
                        }
                        else
                        {
                            echo "Current Research Projects";
                        }
                    ?>
                </h1>
            </div>
            <div class="panel-body">
                <p style="text-align:center;">Click a Project to learn a bit more about it...</p>
                <?php
                    foreach($projects as $project)
                    {
                        ?>
                            <a href="?mode=project&id=<?php echo $project->getId(); ?>">
                                <div class="well well-sm profile">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img style="max-width:100%;max-height:100%;" class="img-thumbnail" src="<?php echo $project->getFullLogo(); ?>" />
                                        </div>
                                        <div class="col-md-8">
                                            <h4><?php echo $project->getName(); ?></h4>
                                            <p><?php echo html_entity_decode($project->getDescription()); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>