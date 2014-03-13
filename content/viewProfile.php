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
        <div class="panel panel-default">
            <div class="panel-body">

                <div class="well">
                    <div class="row">
                        <div class="col-md-4">
                            <img style="max-width:100%;max-height:100%" class="img-thumbnail" src="<?php echo $profile->getFullPhoto(); ?>" />
                        </div>
                        <div class="col-md-8">
                            <h3 class="text-primary"><b><?php echo $profile->getRealName(); ?></b><br /><em><small><?php echo $profile->getRole(); ?><br /><a href="mailto:<?php echo $profile->getEmail(); ?>"><?php echo $profile->getEmail(); ?></a></small></em></h3><br/>

                            <?php echo html_entity_decode($profile->getBio(),ENT_QUOTES); ?><br />
                            <div class="btn-group">
                                <?php
                                    if(strlen($profile->getTwitter()) > 0)
                                    {
                                        ?>
                                            <a target='_blank' href='http://twitter.com/<?php echo $profile->getTwitter(); ?>' class="btn btn-sm btn-info"><img src="images/twitter-2.png"/>@<?php echo $profile->getTwitter(); ?></a>
                                        <?php
                                    }

                                    if(strlen($profile->getLinkedIn()) > 0)
                                    {
                                        ?>
                                            <a target='_blank' href="<?php echo $profile->getLinkedIn() ?>" class="btn btn-sm btn-primary"><img src="images/linkedin.png"/> linkedIn</a>
                                        <?php
                                    }

                                    if(strlen($profile->getScholar()) > 0)
                                    {
                                        ?>
                                            <a target='_blank' href="<?php echo $profile->getScholar() ?>" class="btn btn-sm btn-warning"><img src="images/google.png"/> Scholar</a>
                                        <?php
                                    }

                                    if(strlen($profile->getWebsite()) > 0)
                                    {
                                        ?>
                                            <a target='_blank' href="http://<?php echo $profile->getWebsite() ?>" class="btn btn-sm btn-success" style="height:42px">My Website</a>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Projects I work on
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                My Publications
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>