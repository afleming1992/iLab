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
    $(document).ready(function() {
        $("#results").load("ajax/getPublicationList.php", {'page':0,'numberPerPage':10}, function() {$("#1-pagination-li").addClass('active');}).slideDown(4000);  //initial page number to load

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

        $("#pagination-li-previous").click(function (e){
            $("#results").prepend('<div style="margin-left:auto;margin-right:auto;" class="loading-indication"><img src="images/loading.gif" /> Loading...</div>');
            var limit = <?php echo $pages ?>;
            var active = $('.pagination').find('.active').attr('id').split("-");
            var page_num = parseInt(active[0]) - 1;

            $('.pagination-li').removeClass('active');

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
    });
</script>
