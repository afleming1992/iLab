<div class="row col-md-14">
        <div class="col-md-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title">
                        <?php $page->getSection()->getDetails();
                              echo $page->getSection()->getName();
                        ?>
                    </h1>
                </div>
                <div class="panel-body" style="padding:0">
                    <?php
                        echo $sideNav;
                    ?>
                </div>
            </div>
         </div>
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title">
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