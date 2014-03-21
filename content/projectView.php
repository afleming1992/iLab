<?php

  function printSponsors($sponsors)
  {
      if(count($sponsors) > 0)
      {
          foreach($sponsors as $sponsor)
          {

              ?>
              <div class='media sponsor'>
                  <a class='pull-left'>
                      <img style='max-width:50px;max-height:50px;' class='media-object' src='<?php echo $sponsor['sponsor']->getFullLogo(); ?>'>
                  </a>
                  <div class='media-body'>
                      <h5 class='media-heading'><?php echo $sponsor['sponsor']->getName(); ?></h5>
                      <?php
                        if(strlen($sponsor['sponsor']->getWebsite()) > 0)
                        {
                            ?>
                            <a class='btn btn-info btn-xs' href='<?php echo $sponsor['sponsor']->getWebsite(); ?>'><span class='glyphicon glyphicon-globe'></span> Website</a>
                            <?php
                        }
                        ?>
                  </div>
              </div>
              <?php
          }
      }
      else
      {
          ?>
            <div class="well" style="min-height:100%">
                We don't have any organisation in this category
            </div>
          <?php
      }
  }
?>
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
                <h2 class="panel-title"><?php echo $project->getName(); ?></h2>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="well" style="min-height:100%">
                            <img style='max-width:100%;max-height:100%' src="<?php echo $project->getFullLogo(); ?>" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="well">
                            <p><?php echo html_entity_decode($project->getDescription(),ENT_QUOTES); ?></p>
                            <?php
                                if(strlen($project->getWebsite()) > 0)
                                {
                                    ?>
                                        <a target='_blank' href='http://<?php echo $project->getWebsite(); ?>' class="btn btn-info"><span class="glyphicon glyphicon-globe"></span> Website</a>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Who's working on <?php echo $project->getName(); ?></h3>
                            </div>
                            <div class="panel-body">
                                <?php
                                    $collaborators = $project->getContributors();
                                    foreach($collaborators as $collaborator)
                                    {
                                        if($collaborator['hidden'] != 1)
                                        {
                                           echo $collaborator['user']->getProfile()->generateProfileLink();
                                        }
                                    }
                                ?>
                                <script>
                                    $(document).ready(function(){
                                        $(".profile").tooltip({
                                            'html': true
                                        })
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                             <div class="panel-heading">
                                  <h4 class="panel-title">Publications</h4>
                             </div>
                             <div class="panel-body">
                                <div id="publications">

                                </div>
                                <div style="text-align: center;">
                                    <?php echo $pagination ?>
                                </div>
                             </div>
                         </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">Partners</h4>
                            </div>
                            <div class="panel-body">
                                <?php
                                    printSponsors($project->findPartners());
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Project</h4>
            </div>
            <div class="modal-body">
               <a class="btn btn-block btn-danger" href="?mode=delete&type=project&id=<?php echo $project->getId() ?>">Yes</a>
                <a class="btn btn-block btn-success" href="" data-dismiss="modal">No</a>
            </div>
        </div>
    </div>
</div>
<script>
    var numberPerPage = 3;
    $(document).ready(function(){

        $('#publications').load("ajax/getPublicationList.php",{'page':0,'numberPerPage':3,'project':'<?php echo $project->getId(); ?>'});

        $('.paginate_click').click(function(e){
            var limit = <?php echo $pages ?>;
            $("#publications").html("");
            $("#publications").prepend("<div style='margin-left:auto;margin-right:auto;'>Loading...</div>");

            var clicked_id = $(this).attr('id').split('-');
            var page_num = parseInt(clicked_id[0]);

            $('.pagination-li').removeClass('active');

            $("#publications").load("ajax/getPublicationList.php",{'page': (page_num-1),'numberPerPage':3,'project':'<?php echo $project->getId(); ?>'}, function(){

            });

            $("#"+page_num+"-pagination-li").addClass('active');

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
                $("#paginate-li-next").addClass('disabled');
            }
            else
            {
                $("#paginate-li-next").removeClass("disabled");
            }

            return false;
        });

        $("#pagination-li-next").click(function (e){
            $("#publications").html("");
            $("#publications").prepend('<div style="margin-left:auto;margin-right:auto;" class="loading-indication">Loading...</div>');
            var limit = <?php echo $pages ?>;
            var active = $('.pagination').find('.active').attr('id').split("-");
            var page_num = parseInt(active[0]) + 1;

            $('.pagination-li').removeClass('active');

            $("#publications").load("ajax/getPublicationList.php", {'page': (page_num-1),'numberPerPage':3,'project':'<?php echo $project->getId(); ?>'}, function(){

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
            $("#publications").html("");
            $("#publications").prepend('<div style="margin-left:auto;margin-right:auto;" class="loading-indication">Loading...</div>');
            var limit = <?php echo $pages ?>;
            var active = $('.pagination').find('.active').attr('id').split("-");
            var page_num = parseInt(active[0]) - 1;

            $('.pagination-li').removeClass('active');

            $("#publications").load("ajax/getPublicationList.php", {'page': (page_num-1),'numberPerPage':3,'project':'<?php echo $project->getId(); ?>'}, function(){

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