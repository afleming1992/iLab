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
                        <?php echo $page->getTitle(); ?>
                    </h1>
                </div>
                <div class="panel-body">
                    <?php echo $page->getContent(); ?>
                </div>
                <div class="panel-footer">
                    <small>Created by: <a href='#'><?php echo $page->getAuthor()->getRealName(); ?></a> | Last Updated:- <?php echo $page->getTimeLastUpdated(); ?></small>
                </div>
            </div>
        </div>
 </div>