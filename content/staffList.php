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
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">Who we are</h1>
            </div>
            <div class="panel-body">
            <p>Here is our team! To find out more information about someone, click on their box and you'll be taken to their profile</p>
                <?php
                    $count = 0;
                    foreach($users as $user)
                    {

                        ?>
                            <a href="?mode=profile&user=<?php echo $user->getUsername() ?>">
                            <div class="col-md-6">
                                <div class="well profile">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="img-thumbnail" style="max-width:75px;max-height:75px;" src="<?php echo $user->getFullPhoto(); ?>">
                                        </div>
                                        <div class="col-md-8">
                                            <h4><?php echo $user->getRealName(); ?><br/><small><em><?php echo $user->getRole(); ?></em></small></h4>
                                        </div>
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
