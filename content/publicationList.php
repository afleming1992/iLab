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
                <h2 class="panel-title">
                    <?php echo $title ?>
                </h2>
            </div>
            <div class="panel-body">
                <?php
                    if(isset($_GET['username']))
                    {
                        ?>
                            <a class="btn btn-sm btn-primary" href="?mode=profile&user=<?php echo $user->getUsername(); ?>">Back to Profile</a><br /><br />
                        <?php
                    }
                ?>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <input type="text" id="search_title" class="form-control" placeholder="Search by Title..."/>
                    </div>
                    <div class="form-group">
                        <input type="text" id="search_author" class="form-control" placeholder="Search by Author..."/>
                    </div>
                    <div class="form-group">
                        <select id="search_project" class="form-control">
                            <option value="">Search by Project</option>
                            <?php
                                foreach($projects as $project)
                                {
                                    ?>
                                        <option value="<?php echo $project->getId() ?>"><?php echo $project->getName(); ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-sm btn-primary" id="refresh-button">Search</button>
                        <button class="btn btn-sm btn-default" id="clear-button">Clear</button>
                    </div>
                </form>
                <br />
                <div id="results">

                </div>
                <div style="text-align:center;">
                    <?php echo $pagination; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var numberPerPage = 10;
    $(document).ready(function() {
        $("#results").load("ajax/getPublicationList.php", {'page':0,'numberPerPage':numberPerPage,<?php if(isset($_GET['username'])){echo "'username':'".$_GET['username']."'";} ?>}, function() {$("#1-pagination-li").addClass('active');}).slideDown(4000);  //initial page number to load

        $(".paginate_click").click(function (e) {
            var limit = <?php echo $pages ?>;
            $("#results").prepend('<div style="margin-left:auto;margin-right:auto;" class="loading-indication"><img src="images/loading.gif" /> Loading...</div>');

            var clicked_id = $(this).attr("id").split("-"); //ID of clicked element, split() to get page number.
            var page_num = parseInt(clicked_id[0]); //clicked_id[0] holds the page number we need

            $('.pagination-li').removeClass('active'); //remove any active class

            //post page number and load returned data into result element
            //notice (page_num-1), subtract 1 to get actual starting point
            $("#results").load("ajax/getPublicationList.php", {'page': (page_num-1)}, function(){

            });

            $("#"+page_num+"-pagination-li").addClass('active'); //add active class to currently clicked element

            if(page_num == 1)
            {
                $("#pagination-li-previous").addClass('disabled');
            }
            else
            {
                $("#pagination-li-previous").removeClass('disabled');
            }

            if(page_num == limit)
            {
                $("#pagination-li-next").addClass('disabled');
            }
            else
            {
                $("#pagination-li-next").removeClass('disabled');
            }

            return false; //prevent going to herf link
        });

        $("#pagination-li-next").click(function (e){
            $("#results").prepend('<div style="margin-left:auto;margin-right:auto;" class="loading-indication"><img src="images/loading.gif" /> Loading...</div>');
            var limit = <?php echo $pages ?>;
            var active = $('.pagination').find('.active').attr('id').split("-");
            var page_num = parseInt(active[0]) + 1;

            $('.pagination-li').removeClass('active');

            $("#results").load("ajax/getPublicationList.php", {'page': (page_num-1),<?php if(isset($_GET['username'])){echo "'username':'".$_GET['username']."'";} ?>}, function(){

            });

            $("#"+page_num+"-pagination-li").addClass('active'); //add active class to currently clicked element

            if(page_num == 1)
            {
                $("#pagination-li-previous").addClass('disabled');
            }
            else
            {
                $("#pagination-li-previous").removeClass('disabled');
            }

            if(page_num == limit)
            {
                $("#pagination-li-next").addClass('disabled');
            }
            else
            {
                $("#pagination-li-next").removeClass('disabled');
            }

            return false; //prevent going to herf link

        });

        $("#pagination-li-previous").click(function (e){
            $("#results").prepend('<div style="margin-left:auto;margin-right:auto;" class="loading-indication"><img src="images/loading.gif" /> Loading...</div>');
            var limit = <?php echo $pages ?>;
            var active = $('.pagination').find('.active').attr('id').split("-");
            var page_num = parseInt(active[0]) - 1;

            $('.pagination-li').removeClass('active');

            $("#results").load("ajax/getPublicationList.php", {'page': (page_num-1), <?php if(isset($_GET['username'])){echo "'username':'".$_GET['username']."'";} ?>}, function(){

            });

            $("#"+page_num+"-pagination-li").addClass('active'); //add active class to currently clicked element

            if(page_num == 1)
            {
                $("#pagination-li-previous").addClass('disabled');
            }
            else
            {
                $("#pagination-li-previous").removeClass('disabled');
            }

            if(page_num == limit)
            {
                $("#pagination-li-next").addClass('disabled');
            }
            else
            {
                $("#pagination-li-next").removeClass('disabled');
            }

            return false; //prevent going to herf link

        });

        $('#refresh-button').click(function (e){
            $("#results").prepend('<div style="margin-left:auto;margin-right:auto;" class="loading-indication"><img src="images/loading.gif" /> Loading...</div>');
            var limit = <?php echo $pages ?>;
            var active = $('.pagination').find('.active').attr('id').split("-");
            var page_num = parseInt(active[0]);

            var project = $('#search_project').val();
            var title = $('#search_title').val();
            var author = $('#search_author').val();

            $('.pagination-li').removeClass('active');

            $("#results").load("ajax/getPublicationList.php", {'page': (page_num-1),'project': project,'title': title,'author':author,<?php if(isset($_GET['username'])){echo "'username':'".$_GET['username']."'";} ?>}, function(){

            });

            $("#"+page_num+"-pagination-li").addClass('active'); //add active class to currently clicked element

            if(page_num == 1)
            {
                $("#pagination-li-previous").addClass('disabled');
            }
            else
            {
                $("#pagination-li-previous").removeClass('disabled');
            }

            if(page_num == limit)
            {
                $("#pagination-li-next").addClass('disabled');
            }
            else
            {
                $("#pagination-li-next").removeClass('disabled');
            }

            return false; //prevent going to herf link
        });

        $('#clear-button').click(function (e){
            $('#search_title').val("");
            $('#search_author').val("");
            $('#search_project').val("");

            $("#results").prepend('<div style="margin-left:auto;margin-right:auto;" class="loading-indication"><img src="images/loading.gif" /> Loading...</div>');
            var limit = <?php echo $pages ?>;
            var active = $('.pagination').find('.active').attr('id').split("-");
            var page_num = parseInt(active[0]);

            var project = $('#search_project').val();
            var title = $('#search_title').val();
            var author = $('#search_author').val();

            $('.pagination-li').removeClass('active');

            $("#results").load("ajax/getPublicationList.php", {'page': 0,<?php if(isset($_GET['username'])){echo "'username':'".$_GET['username']."'";} ?>}, function(){

            });

            $("#"+page_num+"-pagination-li").addClass('active'); //add active class to currently clicked element

            if(page_num == 1)
            {
                $("#pagination-li-previous").addClass('disabled');
            }
            else
            {
                $("#pagination-li-previous").removeClass('disabled');
            }

            if(page_num == limit)
            {
                $("#pagination-li-next").addClass('disabled');
            }
            else
            {
                $("#pagination-li-next").removeClass('disabled');
            }

            return false;
        });
    });
</script>
