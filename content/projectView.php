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
                                        <a target='_blank' href='<?php echo $project->getWebsite(); ?>' class="btn btn-info"><span class="glyphicon glyphicon-globe"></span> Website</a>
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